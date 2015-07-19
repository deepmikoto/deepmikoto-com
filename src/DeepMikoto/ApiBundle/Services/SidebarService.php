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
        if($page == null || $page == 'home'){
            $data = [
                'image'         => 'https://graph.facebook.com/v2.3/674308009363817/picture?width=100',
                'title'         => 'Vasileniuc Alexandru-Ciprian',
                'subtitle'      => 'Cluj-Napoca, Romania',
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
        if($page == null || $page == 'home'){
            $data = [
                'title' => 'Latest content',
                'items' => [
                    [
                        'image'         => 'https://media-curse.cursecdn.com/attachments/127/57/1.jpg',
                        'title'         => 'New World of Warcraft expansion released',
                        'link'          => '/',
                        'category'      => 'gaming',
                        'categoryLink'  => '/'
                    ],
                    [
                        'image'         => 'https://media-curse.cursecdn.com/attachments/127/57/1.jpg',
                        'title'         => 'New World of Warcraft expansion released',
                        'link'          => '/',
                        'category'      => 'gaming',
                        'categoryLink'  => '/'
                    ],
                    [
                        'image'         => 'https://media-curse.cursecdn.com/attachments/127/57/1.jpg',
                        'title'         => 'New World of Warcraft expansion released',
                        'link'          => '/',
                        'category'      => 'gaming',
                        'categoryLink'  => '/'
                    ],
                    [
                        'image'         => 'https://media-curse.cursecdn.com/attachments/127/57/1.jpg',
                        'title'         => 'New World of Warcraft expansion released',
                        'link'          => '/',
                        'category'      => 'gaming',
                        'categoryLink'  => '/'
                    ]
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