<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 9/27/2015
 * Time: 14:51
 */

namespace DeepMikoto\ApiBundle\Services;

use DeepMikoto\ApiBundle\Security\ApiResponseStatus;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class CodingService
 *
 * @package DeepMikoto\ApiBundle\Services
 */
class CodingService
{
    private $em;

    /**
     * initialize service components
     *
     * @param EntityManager $em
     */
    public function __construct( EntityManager $em )
    {
        $this->em = $em;
    }

    /**
     * @param $posts
     * @return string
     */
    private function processCodingTimelinePosts( $posts )
    {
        $normalizer = new GetSetMethodNormalizer();
        $normalizer->setIgnoredAttributes(
            []
        );
        $normalizer->setCallbacks(
            [
                'date' => function( $date ){
                    /** @var \DateTime $date */
                    $date = $date->format( 'd F Y' );

                    return $date;
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
    public function getCodingTimeline()
    {
        $query = $this->em->getRepository( 'DeepMikotoApiBundle:CodingPost' )->createQueryBuilder( 'c' );
        $query
            ->select( 'c' )
            ->where( 'c.public = 1' )
            ->orderBy( 'c.date', 'DESC' )
        ;
        $codingPosts = $query->getQuery()->getResult();
        $codingPosts = $this->processCodingTimelinePosts( [
            'payload'   => $codingPosts,
            'response'  => ApiResponseStatus::$ALL_OK
        ]);

        return $codingPosts;
    }

    /**
     * @param $id
     * @param $slug
     * @return string
     */
    public function getCodingPost( $id, $slug )
    {
        $codingPost = $this->em->getRepository( 'DeepMikotoApiBundle:CodingPost' )->findOneBy([
            'id'    => $id,
            'slug'  => $slug,
            'public'=> true
        ]);
        $codingPost = $this->processCodingTimelinePosts( [
            'payload'   => $codingPost,
            'response'  => ApiResponseStatus::$ALL_OK
        ]);

        return $codingPost;
    }
} 