<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 9/27/2015
 * Time: 14:42
 */

namespace DeepMikoto\ApiBundle\Controller;


use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CodingController
 *
 * @package DeepMikoto\ApiBundle\Controller
 */
class CodingController extends FOSRestController
{
    /**
     * action used for retrieving coding timeline
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function codingTimelineAction()
    {
        $response = new Response(
            $this->get('deepmikoto.api.coding_manager')->getCodingTimeline(),
            200
        );
        $response->headers->set( 'Content-Type', 'application/json' );
        /** 7 days */
        $response->setSharedMaxAge( 604800 );
        $response->setMaxAge( 0 );

        return $response;
    }

    /**
     * action used for retrieving coding post
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function codingPostAction( Request $request )
    {
        $id = $request->get( 'id', null );
        $slug = $request->get( 'slug', null );
        $response = new Response(
            $this->get('deepmikoto.api.coding_manager')->getCodingPost( $id, $slug ),
            200
        );
        $response->headers->set( 'Content-Type', 'application/json' );
        /** 2 days */
        $response->setSharedMaxAge( 172800 );
        $response->setMaxAge( 0 );

        return $response;
    }
} 