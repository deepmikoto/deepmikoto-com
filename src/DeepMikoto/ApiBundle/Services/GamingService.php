<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 12/29/2015
 * Time: 06:49
 */

namespace DeepMikoto\ApiBundle\Services;

use DeepMikoto\ApiBundle\Security\ApiResponseStatus;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class GamingService
 * @package DeepMikoto\ApiBundle\Services
 */
class GamingService
{
    private $em;
    private $container;

    /**
     * initialize service components
     *
     * @param Container $container
     * @param EntityManager $em
     */
    public function __construct( Container $container, EntityManager $em )
    {
        $this->container = $container;
        $this->em = $em;
    }

    /**
     * @param $posts
     * @return string
     */
    private function processGamingTimelinePosts( $posts )
    {
        $normalizer = new GetSetMethodNormalizer();
        $normalizer->setIgnoredAttributes(
            [ 'cover', 'uploadDir', 'absolutePath', 'file' ]
        );
        $container = $this->container;
        $normalizer->setCallbacks(
            [
                'date' => function( $date ){
                    /** @var \DateTime $date */
                    $date = $date->format( 'd F Y' );

                    return $date;
                },
                'webPath' => function( $webPath ) use( $container ){
                    if( file_exists( $webPath ) && is_file( $webPath ) ){
                        $webPath = [
                            'fullSize' => '/' . $webPath,
                            'timelineSize' => $container->get('liip_imagine.cache.manager')->getBrowserPath(
                                $webPath, 'gaming_timeline_picture'
                            )
                        ];
                        return $webPath;
                    } else {
                        return false;
                    }
                }
            ]
        );
        $serializer = new Serializer(
            [ $normalizer ],
            [ new JsonEncoder() ]
        );
        $posts = $serializer->serialize( $posts, 'json' );

        return $posts;
    }

    /**
     * @return string
     */
    public function getGamingTimeline()
    {
        $query = $this->em->getRepository( 'DeepMikotoApiBundle:GamingPost' )->createQueryBuilder( 'c' );
        $query
            ->select( 'c' )
            ->where( 'c.public = 1' )
            ->orderBy( 'c.date', 'DESC' )
        ;
        $gamingPosts = $query->getQuery()->getResult();
        $gamingPosts = $this->processGamingTimelinePosts( [
            'payload'   => $gamingPosts,
            'response'  => ApiResponseStatus::$ALL_OK
        ]);

        return $gamingPosts;
    }

    /**
     * @param $id
     * @param $slug
     * @return string
     */
    public function getGamingPost( $id, $slug )
    {
        $gamingPost = $this->em->getRepository( 'DeepMikotoApiBundle:GamingPost' )->findOneBy([
            'id'    => $id,
            'slug'  => $slug,
            'public'=> true
        ]);
        $gamingPost = $this->processGamingTimelinePosts( [
            'payload'   => $gamingPost,
            'response'  => ApiResponseStatus::$ALL_OK
        ]);

        return $gamingPost;
    }
}