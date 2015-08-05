<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 7/18/2015
 * Time: 02:56
 */

namespace DeepMikoto\ApiBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class PhotographyService
 *
 * @package DeepMikoto\ApiBundle\Services
 */
class PhotographyService
{
    private $container;
    private $em;
    private $request;

    /**
     * initialize service components
     *
     * @param Container $container
     * @param EntityManager $em
     * @param RequestStack $requestStack
     */
    public function __construct( Container $container, EntityManager $em, RequestStack $requestStack )
    {
        $this->em = $em;
        $this->request = $requestStack->getCurrentRequest();
        $this->container = $container;
    }

    /**
     * @return string
     */
    public function getPhotographyTimeline()
    {
        $query = $this->em->getRepository( 'DeepMikotoApiBundle:PhotographyPost' )->createQueryBuilder( 'p' );
        $query
            ->select( 'p' )
            ->where( 'p.public = 1' )
            ->orderBy( 'p.date', 'DESC' )
        ;
        $photographyPosts = $query->getQuery()->getResult();
        $photographyPosts = $this->processPhotographyTimelinePosts( $photographyPosts );

        return $photographyPosts;
    }

    /**
     * @param $posts
     * @return string
     */
    private function processPhotographyTimelinePosts( $posts )
    {
        $normalizer = new GetSetMethodNormalizer();
        $normalizer->setIgnoredAttributes(
            []
        );
        $container = $this->container;
        $normalizer->setCallbacks(
            [
                'photos' => function( $photos ) use( $container ){
                    $processedPhotos = [];
                    /** @var \DeepMikoto\ApiBundle\Entity\PhotographyPostPhoto $photo */
                    foreach( $photos as $photo ){
                        $processedPhotos[] = [
                            'originalPath'  => $photo->getUploadDir() . '/' . $photo->getPath(),
                            'path'          => $container->get('liip_imagine.cache.manager')->getBrowserPath(
                                $photo->getUploadDir() . '/' . $photo->getPath(), 'timeline_picture'
                            ),
                        ];
                    }

                    return $processedPhotos;
                },
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
} 