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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;
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
        $this->container = $container;
        $this->em = $em;
        $this->router = $router;
    }

    /**
     * @param $posts
     * @return string
     */
    private function processGamingPost( $posts )
    {
        $normalizer = new GetSetMethodNormalizer();
        $normalizer->setIgnoredAttributes(
            [ 'cover', 'uploadDir', 'absolutePath', 'file', 'views' ]
        );
        $container = $this->container;
        $normalizer->setCallbacks(
            [
                'date' => function( $date ){
                    /** @var \DateTime $date */
                    $date = $date->format( 'F jS, Y' );

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
     * @param $posts
     * @return string
     */
    private function processGamingTimelinePosts( $posts )
    {
        $normalizer = new GetSetMethodNormalizer();
        $normalizer->setIgnoredAttributes(
            [ 'cover', 'uploadDir', 'absolutePath', 'file', 'date', 'public', 'views', 'content', 'hideCoverInPost' ]
        );
        $container = $this->container;
        $normalizer->setCallbacks(
            [
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
     * @param int $limit
     * @param int $offset
     * @return string
     */
    public function getGamingTimeline( $limit = 10, $offset = 0 )
    {
        $query = $this->em->getRepository( 'DeepMikotoApiBundle:GamingPost' )->createQueryBuilder( 'c' );
        $query
            ->select( 'c' )
            ->where( 'c.public = 1' )
            ->setMaxResults( $limit )
            ->setFirstResult( $offset )
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
     * @param null|Request $request
     * @return string
     */
    public function getGamingPost( $id, $slug, $request = null )
    {
        $gamingPostEntity = $this->em->getRepository( 'DeepMikotoApiBundle:GamingPost' )->findOneBy([
            'id'    => $id,
            'slug'  => $slug,
            'public'=> true
        ]);
        if( $gamingPostEntity != null ){
            $gamingPost = $this->processGamingPost([
                'payload'   => $gamingPostEntity,
                'response'  => ApiResponseStatus::$ALL_OK
            ]);
            if( $request != null )
                $this->container->get( 'deepmikoto.api.tracking_manager' )->addPostView( $gamingPostEntity, $request );
        } else {
            $gamingPost = [
                'payload'   => null,
                'response'  => ApiResponseStatus::$INVALID_REQUEST_PARAMETERS
            ];
        }

        return $gamingPost;
    }

    /**
     * fetches gaming posts ordered by views
     *
     * @param int $limit
     * @return array
     */
    public function getGamingSidebarPosts( $limit = 4 )
    {
        $em = $this->em;
        $router = $this->router;
        $repository = $em->getRepository( 'DeepMikotoApiBundle:GamingPost' );
        $query = $repository->createQueryBuilder( 'g' );
        $query
            ->select(
                'g.id as id, g.slug, g.title, g.date, ' .
                'COUNT( DISTINCT gpv.id  ) as HIDDEN views, g.cover'
            )
            ->leftJoin( 'g.views', 'gpv', 'WITH', 'gpv.post = g.id' )
            ->groupBy( 'id' )
            ->where( 'g.public = :true' )
            ->setParameter( 'true', true )
            ->orderBy( 'views', 'DESC' )
            ->setMaxResults( $limit )
        ;
        $gamingPosts = $query->getQuery()->getResult();
        $cacheManager = $this->container->get('liip_imagine.cache.manager');
        foreach( $gamingPosts as $key => $gamingPost ){
            $gamingPosts[ $key ][ 'link' ] = $router->generate( 'deepmikoto_app_gaming_post', [
                'id'   => $gamingPost[ 'id' ],
                'slug' => $gamingPost[ 'slug' ]
            ], $router::ABSOLUTE_PATH );
            $gamingPosts[ $key ][ 'image' ] = $cacheManager->getBrowserPath(
                'images/gaming/' . $gamingPost[ 'id' ] . '/' . $gamingPost[ 'cover' ], 'tiny_thumb'
            );
            unset( $gamingPosts[ $key ][ 'id' ] );
            unset( $gamingPosts[ $key ][ 'slug' ] );
            unset( $gamingPosts[ $key ][ 'cover' ] );
        }

        if( $limit > 1 ){
            return $gamingPosts;
        } else {
            return isset( $gamingPosts[0] ) ? $gamingPosts[0] : $gamingPosts;
        }
    }

    /**
     * @param $term
     * @param int $limit
     * @return array
     */
    public function getSuggestions( $term, $limit = 5 )
    {
        $posts = $this->em
            ->getRepository('DeepMikotoApiBundle:GamingPost')
            ->createQueryBuilder('p')
            ->select('p.id', 'p.slug', 'p.title', 'count( distinct v.id ) as hidden views')
            ->leftJoin('p.views', 'v')
            ->groupBy('p.id')
            ->where('p.public = 1')
            ->andWhere('p.slug LIKE :term')
            ->setParameter('term', '%' . $term . '%')
            ->orderBy('views', 'desc')
            ->setMaxResults( $limit )
            ->getQuery()
            ->getResult()
        ;
        $processed = [];
        $router = $this->router;
        foreach ( $posts as $post ) {
            $processed[] = [
                'title' => $post[ 'title' ],
                'url' => $router->generate( 'deepmikoto_app_gaming_post', [
                    'id' => $post[ 'id' ],
                    'slug' => $post[ 'slug' ]
                ]),
                'category' => 'Gaming'
            ];
        }

        return $processed;
    }
}