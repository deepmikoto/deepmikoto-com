<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 7/18/2015
 * Time: 02:42
 */

namespace DeepMikoto\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

/**
 * Class SidebarController
 *
 * @package DeepMikoto\ApiBundle\Controller
 */
class SidebarController extends FOSRestController
{
    /**
     * action used for retrieving primary sidebar block
     * depending on the current page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sidebarPrimaryBlockAction()
    {
        $data = $this->get('deepmikoto.api.sidebar_manager')->getSidebarPrimaryBlockData();
        $view = $this->view($data, 200)
            ->setTemplate('DeepMikotoApiBundle:Templates:sidebar/_primary_block.html.twig')
        ;
        $response = $this->handleView( $view );
        $response->setExpires( new \DateTime('+1 day') );
        $response->setPublic();

        return $response;
    }
} 