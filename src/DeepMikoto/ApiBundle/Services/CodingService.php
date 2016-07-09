<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 9/27/2015
 * Time: 14:51
 */

namespace DeepMikoto\ApiBundle\Services;

use DeepMikoto\ApiBundle\Entity\CodingCategory;
use DeepMikoto\ApiBundle\Security\ApiResponseStatus;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;
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
        $this->em = $em;
        $this->container = $container;
        $this->router = $router;
    }

    /**
     * @param $posts
     * @return string
     */
    private function processCodingTimelinePosts( $posts )
    {
        $normalizer = new GetSetMethodNormalizer();
        $normalizer->setIgnoredAttributes(
            [ 'content', 'views' ]
        );
        $cacheManager = $this->container->get('liip_imagine.cache.manager');
        $normalizer->setCallbacks(
            [
                'date' => function( $date ){
                    /** @var \DateTime $date */
                    $date = $date->format( 'F dS, Y' );

                    return $date;
                },
                'categories' => function( PersistentCollection $codingCategories ) use ( $cacheManager ) {
                    $categories = [];
                    /** @var CodingCategory $category */
                    foreach( $codingCategories as $category ) {
                        $categories[] = [
                            'name' => $category->getName(),
                            'image' => $cacheManager->getBrowserPath( $category->getWebPath(), '20_20' )
                        ];
                    }

                    return $categories;
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
    private function processCodingPosts( $posts )
    {
        $normalizer = new GetSetMethodNormalizer();
        $normalizer->setIgnoredAttributes(
            [ 'views', 'categories' ]
        );
        $normalizer->setCallbacks(
            [
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
     * @param null|Request $request
     * @return string
     */
    public function getCodingPost( $id, $slug, $request = null )
    {
        $codingPostEntity = $this->em->getRepository( 'DeepMikotoApiBundle:CodingPost' )->findOneBy([
            'id'    => $id,
            'slug'  => $slug,
            'public'=> true
        ]);
        if( $codingPostEntity != null ){
            $codingPost = $this->processCodingPosts( [
                'payload'   => $codingPostEntity,
                'response'  => ApiResponseStatus::$ALL_OK
            ]);
            if( $request != null )
                $this->container->get( 'deepmikoto.api.tracking_manager' )->addPostView( $codingPostEntity, $request );
        } else {
            $codingPost = [
                'payload'   => null,
                'response'  => ApiResponseStatus::$INVALID_REQUEST_PARAMETERS
            ];
        }

        return $codingPost;
    }

    /**
     * fetches coding posts ordered by views
     *
     * @param int $limit
     * @return array
     */
    public function getCodingSidebarPosts( $limit = 4 )
    {
        $em = $this->em;
        $router = $this->router;
        $repository = $em->getRepository( 'DeepMikotoApiBundle:CodingPost' );
        $query = $repository->createQueryBuilder( 'c' );
        $query
            ->select(
                'c.id as id, c.slug, c.title, c.date, ' .
                'COUNT( DISTINCT cpv.id  ) as HIDDEN views'
            )
            ->leftJoin( 'c.views', 'cpv', 'WITH', 'cpv.post = c.id' )
            ->groupBy( 'id' )
            ->where( 'c.public = :true' )
            ->setParameter( 'true', true )
            ->orderBy( 'views', 'DESC' )
            ->setMaxResults( $limit )
        ;
        $codingPosts = $query->getQuery()->getResult();
        foreach( $codingPosts as $key => $codingPost ){
            $codingPosts[ $key ][ 'link' ] = $router->generate( 'deepmikoto_app_coding_post', [
                'id'   => $codingPost[ 'id' ],
                'slug' => $codingPost[ 'slug' ]
            ], $router::ABSOLUTE_PATH );
            unset( $codingPosts[ $key ][ 'id' ] );
            unset( $codingPosts[ $key ][ 'slug' ] );
        }

        if( $limit > 1 ){
            return $codingPosts;
        } else {
            return isset( $codingPosts[0] ) ? $codingPosts[0] : $codingPosts;
        }
    }
} 