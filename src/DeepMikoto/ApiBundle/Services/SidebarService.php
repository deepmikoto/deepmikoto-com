<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 7/18/2015
 * Time: 02:56
 */

namespace DeepMikoto\ApiBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class SidebarService
 *
 * @package DeepMikoto\ApiBundle\Services
 */
class SidebarService
{
    private $em;
    private $request;

    /**
     * initialize service components
     *
     * @param EntityManager $em
     * @param RequestStack $requestStack
     */
    public function __construct(EntityManager $em, RequestStack $requestStack)
    {
        $this->em = $em;
        $this->request = $requestStack->getCurrentRequest();
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
            $data = [
                'image'         => 'https://graph.facebook.com/v2.3/674308009363817/picture?width=100',
                'title'         => 'Vasileniuc Alexandru-Ciprian',
                'subtitle'      => 'Cluj-Napoca, Romania',
                'description'   => 'cannot be put in words ;)'
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
                        'image'         => 'https://media-curse.cursecdn.com/attachments/127/57/1.jpg',
                        'title'         => 'New World of Warcraft expansion released',
                        'category'      => 'photography'
                    ],
                    [
                        'image'         => 'https://media-curse.cursecdn.com/attachments/127/57/1.jpg',
                        'title'         => 'New World of Warcraft expansion released',
                        'category'      => 'coding'
                    ],
                    [
                        'image'         => 'https://media-curse.cursecdn.com/attachments/127/57/1.jpg',
                        'title'         => 'New World of Warcraft expansion released',
                        'category'      => 'gaming'
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
                        'category'      => 'photography'
                    ],
                    [
                        'image'         => 'https://s-media-cache-ak0.pinimg.com/originals/3e/81/22/3e812240328e5185e62192fe4fa7fadd.jpg',
                        'title'         => 'A day in nature',
                        'category'      => 'photography'
                    ],
                    [
                        'image'         => 'https://s-media-cache-ak0.pinimg.com/originals/3e/81/22/3e812240328e5185e62192fe4fa7fadd.jpg',
                        'title'         => 'A day in nature',
                        'category'      => 'photography'
                    ],
                    [
                        'image'         => 'https://s-media-cache-ak0.pinimg.com/originals/3e/81/22/3e812240328e5185e62192fe4fa7fadd.jpg',
                        'title'         => 'A day in nature',
                        'category'      => 'photography'
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
                        'category'      => 'coding'
                    ],
                    [
                        'image'         => 'https://insidecroydon.files.wordpress.com/2013/02/code-club.jpg',
                        'title'         => 'SPA Mania',
                        'category'      => 'coding'
                    ],
                    [
                        'image'         => 'https://insidecroydon.files.wordpress.com/2013/02/code-club.jpg',
                        'title'         => 'SPA Mania',
                        'category'      => 'coding'
                    ],
                    [
                        'image'         => 'https://insidecroydon.files.wordpress.com/2013/02/code-club.jpg',
                        'title'         => 'SPA Mania',
                        'category'      => 'coding'
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
                        'category'      => 'gaming'
                    ],
                    [
                        'image'         => 'https://media-curse.cursecdn.com/attachments/127/57/1.jpg',
                        'title'         => 'New World of Warcraft expansion released',
                        'category'      => 'gaming'
                    ],
                    [
                        'image'         => 'https://media-curse.cursecdn.com/attachments/127/57/1.jpg',
                        'title'         => 'New World of Warcraft expansion released',
                        'category'      => 'gaming'
                    ],
                    [
                        'image'         => 'https://media-curse.cursecdn.com/attachments/127/57/1.jpg',
                        'title'         => 'New World of Warcraft expansion released',
                        'category'      => 'gaming'
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