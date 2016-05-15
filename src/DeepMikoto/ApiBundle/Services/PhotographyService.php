<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 7/18/2015
 * Time: 02:56
 */

namespace DeepMikoto\ApiBundle\Services;

use DeepMikoto\ApiBundle\Security\ApiResponseStatus;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;
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
    private $router;

    /**
     * initialize service components
     *
     * @param Container $container
     * @param EntityManager $em
     * @param Router $router
     */
    public function __construct( Container $container, EntityManager $em, Router $router )
    {
        $this->em = $em;
        $this->container = $container;
        $this->router = $router;
    }

    /**
     * @param $posts
     * @return string
     */
    private function processPhotographyTimelinePosts( $posts )
    {
        $normalizer = new GetSetMethodNormalizer();
        $normalizer->setIgnoredAttributes(
            [ 'views' ]
        );
        $container = $this->container;
        $router = $this->router;
        $normalizer->setCallbacks(
            [
                'photos' => function( $photos ) use( $container, $router ){
                    $processedPhotos = [];
                    /** @var \DeepMikoto\ApiBundle\Entity\PhotographyPostPhoto $photo */
                    foreach( $photos as $photo ){
                        $processedPhotos[] = [
                            'downLink'  => $router->generate( 'deepmikoto_api_photography_cache', [
                                'id'   => $photo->getId(),
                                'path' => $photo->getPath()
                            ], $router::ABSOLUTE_URL ),
                            'url'       => $container->get('liip_imagine.cache.manager')->getBrowserPath(
                                $photo->getWebPath(), 'timeline_picture'
                            ),
                            'downloads' => $photo->getDownloads()->count()
                        ];
                    }

                    return $processedPhotos;
                },
                'date' => function( $date ){
                    /** @var \DateTime $date */
                    $date = $date->format( 'F dS, Y' );

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
     * fetches max for photography posts ordered by most
     * image downloads
     *
     * @param int $limit
     * @return array
     */
    public function getPhotographySidebarPosts( $limit = 4 )
    {
        $em = $this->em;
        $router = $this->router;
        $repository = $em->getRepository( 'DeepMikotoApiBundle:PhotographyPost' );
        $query = $repository->createQueryBuilder( 'p' );
        $query
            ->select(
                'p.id as id, p.slug, p.title, p.date, \'photography\' as category, ' .
                'COUNT( DISTINCT ppd.id  ) as HIDDEN downloads, pp.id as imageId, pp.path as imagePath'
            )
            ->leftJoin( 'p.photos', 'pp', 'WITH', 'pp.photographyPost = p.id' )
            ->leftJoin( 'pp.downloads', 'ppd', 'WITH', 'ppd.photographyPostPhoto = pp.id' )
            ->groupBy( 'id' )
            ->where( 'p.public = :true' )
            ->setParameter( 'true', true )
            ->orderBy( 'downloads', 'DESC' )
            ->setMaxResults( $limit )
        ;
        $photographyPosts = $query->getQuery()->getResult();
        foreach( $photographyPosts as $key => $photographyPost ){
            $photographyPosts[ $key ][ 'link' ] = $router->generate( 'deepmikoto_app_photography_post', [
                'id'   => $photographyPost[ 'id' ],
                'slug' => $photographyPost[ 'slug' ]
            ], $router::ABSOLUTE_PATH );
            $photographyPosts[ $key ][ 'image' ] = $this->container->get('liip_imagine.cache.manager')->getBrowserPath(
                'images/photography/' . $photographyPost[ 'imageId' ] . '/' . $photographyPost[ 'imagePath' ], 'tiny_thumb'
            );
            unset( $photographyPosts[ $key ][ 'id' ] );
            unset( $photographyPosts[ $key ][ 'slug' ] );
            unset( $photographyPosts[ $key ][ 'imageId' ] );
            unset( $photographyPosts[ $key ][ 'imagePath' ] );
        }

        if( $limit > 1 ){
            return $photographyPosts;
        } else {
            return isset( $photographyPosts[0] ) ? $photographyPosts[0] : $photographyPosts;
        }
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
        $photographyPosts = $this->processPhotographyTimelinePosts( [
            'payload'   => $photographyPosts,
            'response'  => ApiResponseStatus::$ALL_OK
        ] );

        return $photographyPosts;
    }

    /**
     * @param $id
     * @param $slug
     * @param null | Request $request
     * @return string
     */
    public function getPhotographyPost( $id, $slug, $request = null )
    {
        $photographyPostEntity = $this->em->getRepository( 'DeepMikotoApiBundle:PhotographyPost' )->findOneBy([
            'id'    => $id,
            'slug'  => $slug,
            'public'=> true
        ]);
        if( $photographyPostEntity != null ){
            $photographyPost = $this->processPhotographyTimelinePosts( [
                'payload'   => $photographyPostEntity,
                'response'  => ApiResponseStatus::$ALL_OK
            ]);
            if( $request != null )
                $this->container->get( 'deepmikoto.api.tracking_manager' )->addPostView( $photographyPostEntity, $request );
        } else {
            $photographyPost = [
                'payload'   => null,
                'response'  => ApiResponseStatus::$INVALID_REQUEST_PARAMETERS
            ];
        }

        return $photographyPost;
    }
} 