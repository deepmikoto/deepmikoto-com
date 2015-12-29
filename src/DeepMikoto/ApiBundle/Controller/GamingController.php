<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 12/29/2015
 * Time: 06:42
 */

namespace DeepMikoto\ApiBundle\Controller;


use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GamingController
 * @package DeepMikoto\ApiBundle\Controller
 */
class GamingController extends FOSRestController
{
    /**
     * action used for retrieving gaming timeline
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function gamingTimelineAction()
    {
        $response = new Response(
            $this->get('deepmikoto.api.gaming_manager')->getGamingTimeline(),
            200
        );
        $response->headers->set( 'Content-Type', 'application/json' );
        /** 7 days */
        $response->setSharedMaxAge( 604800 );
        $response->setMaxAge( 0 );

        return $response;
    }

    /**
     * action used for retrieving gaming post
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function gamingPostAction( Request $request )
    {
        $id = $request->get( 'id', null );
        $slug = $request->get( 'slug', null );
        $response = new Response(
            $this->get('deepmikoto.api.gaming_manager')->getGamingPost( $id, $slug ),
            200
        );
        $response->headers->set( 'Content-Type', 'application/json' );
        /** 2 days */
        $response->setSharedMaxAge( 172800 );
        $response->setMaxAge( 0 );

        return $response;
    }
}