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

/**
 * Class SidebarService
 *
 * @package DeepMikoto\ApiBundle\Services
 */
class SidebarService
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
    public function __construct(Container $container, EntityManager $em, RequestStack $requestStack)
    {
        $this->em = $em;
        $this->request = $requestStack->getCurrentRequest();
        $this->container = $container;
    }

    /**
     * generates sidebar primary block data depending on the current page
     *
     * @param $page
     * @return array
     */
    public function getSidebarPrimaryBlockData( $page )
    {
        in_array( $page, [ 'help' ] ) ? $page = 'home' : null;
        /** @var \DeepMikoto\ApiBundle\Entity\SidebarPrimaryBlock $primaryBlock */
        $primaryBlock = $this->em->getRepository( 'DeepMikotoApiBundle:SidebarPrimaryBlock' )->findOneBy([
            'type' => $page
        ]);
        if( $primaryBlock != null ){
            $data = [
                'image'       => $this->container->get('liip_imagine.cache.manager')->getBrowserPath( 'images/api/' . $primaryBlock->getPicture(), 'sidebar_primary_block' ),
                'title'       => $primaryBlock->getTitle(),
                'subtitle'    => $primaryBlock->getSubtitle(),
                'description' => $primaryBlock->getContent()
            ];
        } else {
            $data = [];
        }

        return $data;
    }

    /**
     * generates sidebar related block data depending on the current page
     *
     * @param $page
     * @return array
     */
    public function getSidebarRelatedBlockData( $page )
    {
        $photographyManager = $this->container->get( 'deepmikoto.api.photography_manager' );
        $codingManager = $this->container->get( 'deepmikoto.api.coding_manager' );
        $gamingManager = $this->container->get( 'deepmikoto.api.gaming_manager' );
        if( $page == 'home' || $page == 'help' ){
            $data = [
                'title' => 'Latest content',
                'items' => [
                    $codingManager->getCodingSidebarPosts( 1 ),
                    $gamingManager->getGamingSidebarPosts( 1 ),
                    $photographyManager->getPhotographySidebarPosts( 1 )
                ]
            ];
        } elseif ( $page == 'photography' ) {
            $data = [
                'title' => 'Popular in Photography',
                'items' => $photographyManager->getPhotographySidebarPosts()
            ];
        } elseif ( $page == 'coding' ) {
            $data = [
                'title' => 'Popular in Coding',
                'items' => $codingManager->getCodingSidebarPosts()
            ];
        } elseif ( $page == 'gaming' ) {
            $data = [
                'title' => 'Popular in Gaming',
                'items' => $gamingManager->getGamingSidebarPosts()
            ];
        } else {
            $data = [];
        }

        return $data;
    }

    /**
     * generates sidebar add block data depending on the current page
     *
     * @param $page
     * @return array
     */
    public function getSidebarAddBlockData( $page )
    {
        $data = [];

        return $data;
    }
} 