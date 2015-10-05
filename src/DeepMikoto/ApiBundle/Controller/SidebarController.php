<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 7/18/2015
 * Time: 02:42
 */

namespace DeepMikoto\ApiBundle\Controller;

use DeepMikoto\ApiBundle\Security\ApiResponseStatus;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SidebarController
 *
 * @package DeepMikoto\ApiBundle\Controller
 */
class SidebarController extends FOSRestController
{
    /**
     * action used for retrieving sidebar components
     * depending on the current page
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sidebarComponentsAction( Request $request )
    {
        $page = $request->get( 'page', null );
        /** @var \DeepMikoto\ApiBundle\Services\SidebarService $sidebarManager */
        $sidebarManager = $this->get('deepmikoto.api.sidebar_manager');
        $components = [
            'primaryBlock' => $this->render(
                'DeepMikotoApiBundle:Templates:sidebar/_primary_block.html.twig',
                $sidebarManager->getSidebarPrimaryBlockData( $page )
            )->getContent(),
            'relatedBlock' => $this->render(
                'DeepMikotoApiBundle:Templates:sidebar/_related_block.html.twig',
                $sidebarManager->getSidebarRelatedBlockData( $page )
            )->getContent(),
            'adBlock' => $this->render(
                'DeepMikotoApiBundle:Templates:sidebar/_add_block.html.twig',
                $sidebarManager->getSidebarAddBlockData( $page )
            )->getContent()
        ];
        $response = new Response(
            $this->get( 'serializer' )->serialize( [
                'payload' => $components,
                'status'  => ApiResponseStatus::$ALL_OK
            ], 'json' )
        );
        $response->headers->set( 'Content-Type', 'application/json' );
        /** 7 days */
        $response->setSharedMaxAge( 604800 );
        $response->setMaxAge( 0 );

        return $response;
    }
}