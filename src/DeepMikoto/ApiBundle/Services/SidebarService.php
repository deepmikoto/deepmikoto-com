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
     * @return array
     */
    public function getSidebarPrimaryBlockData()
    {
        $page = $this->request->get('page');
        if( $page == 'home' ){
            /** @var \DeepMikoto\ApiBundle\Entity\SidebarPrimaryBlock $primaryBlock */
            $primaryBlock = $this->em->getRepository( 'DeepMikotoApiBundle:SidebarPrimaryBlock' )->findOneBy([
                'type' => $page
            ]);
            $data = [
                'image'         => $this->container->get('liip_imagine.cache.manager')->getBrowserPath( 'images/api/' . $primaryBlock->getPicture(), 'sidebar_primary_block' ),
                'title'         => $primaryBlock->getTitle(),
                'subtitle'      => $primaryBlock->getSubtitle(),
                'description'   => $primaryBlock->getContent()
            ];
        } elseif ( $page == 'photography' ){
            $data = [
                'image'         => 'https://julia1791.files.wordpress.com/2014/05/blackwhitephotography.jpg',
                'title'         => 'Nikon D5100 DSLR',
                'subtitle'      => 'Cluj-Napoca, Romania',
                'description'   => 'cannot be put in words ;)'
            ];
        } elseif ( $page == 'coding' ){
            $data = [
                'image'         => 'https://dillieodigital.files.wordpress.com/2011/07/computercode.jpeg',
                'title'         => 'Marionette',
                'subtitle'      => 'with a pinch of Symfony',
                'description'   => 'cannot be put in words ;)'
            ];
        } elseif ( $page == 'gaming' ){
            $data = [
                'image'         => 'https://i.imgur.com/7SVhwH9.jpg',
                'title'         => 'Gaming is not a game',
                'subtitle'      => 'Give me moar gaming',
                'description'   => 'cannot be put in words ;)'
            ];
        } else {
            $data = [];
        }

        return $data;
    }

    /**
     * generates sidebar related block data depending on the current page
     *
     * @return array
     */
    public function getSidebarRelatedBlockData()
    {
        $page = $this->request->get('page');
        if( $page == 'home' ){
            $data = [
                'title' => 'Latest content',
                'items' => [
                    [
                        'image'         => 'https://s-media-cache-ak0.pinimg.com/originals/3e/81/22/3e812240328e5185e62192fe4fa7fadd.jpg',
                        'title'         => 'A day in nature',
                        'category'      => 'photography',
                        'date'          => new \DateTime()
                    ],
                    [
                        'image'         => 'https://insidecroydon.files.wordpress.com/2013/02/code-club.jpg',
                        'title'         => 'SPA Mania',
                        'category'      => 'coding',
                        'date'          => new \DateTime()
                    ],
                    [
                        'image'         => 'https://media-curse.cursecdn.com/attachments/127/57/1.jpg',
                        'title'         => 'New World of Warcraft expansion released',
                        'category'      => 'gaming',
                        'date'          => new \DateTime()
                    ]
                ]
            ];
        } elseif ( $page == 'photography' ) {
            $data = [
                'title' => 'Popular in Photography',
                'items' => [
                    [
                        'image'         => 'https://s-media-cache-ak0.pinimg.com/originals/3e/81/22/3e812240328e5185e62192fe4fa7fadd.jpg',
                        'title'         => 'A day in nature',
                        'date'          => new \DateTime()
                    ],
                    [
                        'image'         => 'https://s-media-cache-ak0.pinimg.com/originals/3e/81/22/3e812240328e5185e62192fe4fa7fadd.jpg',
                        'title'         => 'A day in nature',
                        'date'          => new \DateTime()
                    ],
                    [
                        'image'         => 'https://s-media-cache-ak0.pinimg.com/originals/3e/81/22/3e812240328e5185e62192fe4fa7fadd.jpg',
                        'title'         => 'A day in nature',
                        'date'          => new \DateTime()
                    ],
                    [
                        'image'         => 'https://s-media-cache-ak0.pinimg.com/originals/3e/81/22/3e812240328e5185e62192fe4fa7fadd.jpg',
                        'title'         => 'A day in nature',
                        'date'          => new \DateTime()
                    ]
                ]
            ];
        } elseif ( $page == 'coding' ) {
            $data = [
                'title' => 'Popular in Coding',
                'items' => [
                    [
                        'image'         => 'https://insidecroydon.files.wordpress.com/2013/02/code-club.jpg',
                        'title'         => 'SPA Mania',
                        'date'          => new \DateTime()
                    ],
                    [
                        'image'         => 'https://insidecroydon.files.wordpress.com/2013/02/code-club.jpg',
                        'title'         => 'SPA Mania',
                        'date'          => new \DateTime()
                    ],
                    [
                        'image'         => 'https://insidecroydon.files.wordpress.com/2013/02/code-club.jpg',
                        'title'         => 'SPA Mania',
                        'date'          => new \DateTime()
                    ],
                    [
                        'image'         => 'https://insidecroydon.files.wordpress.com/2013/02/code-club.jpg',
                        'title'         => 'SPA Mania',
                        'date'          => new \DateTime()
                    ]
                ]
            ];
        } elseif ( $page == 'gaming' ) {
            $data = [
                'title' => 'Popular in Gaming',
                'items' => [
                    [
                        'image'         => 'https://media-curse.cursecdn.com/attachments/127/57/1.jpg',
                        'title'         => 'New World of Warcraft expansion released',
                        'date'          => new \DateTime()
                    ],
                    [
                        'image'         => 'https://media-curse.cursecdn.com/attachments/127/57/1.jpg',
                        'title'         => 'New World of Warcraft expansion released',
                        'date'          => new \DateTime()
                    ],
                    [
                        'image'         => 'https://media-curse.cursecdn.com/attachments/127/57/1.jpg',
                        'title'         => 'New World of Warcraft expansion released',
                        'date'          => new \DateTime()
                    ],
                    [
                        'image'         => 'https://media-curse.cursecdn.com/attachments/127/57/1.jpg',
                        'title'         => 'New World of Warcraft expansion released',
                        'date'          => new \DateTime()
                    ],
                ]
            ];
        } else {
            $data = [];
        }

        return $data;
    }

    /**
     * generates sidebar add block data depending on the current page
     *
     * @return array
     */
    public function getSidebarAddBlockData()
    {
        $data = [];

        return $data;
    }
} 