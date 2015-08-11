<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 7/18/2015
 * Time: 02:42
 */

namespace DeepMikoto\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PhotographyController
 *
 * @package DeepMikoto\ApiBundle\Controller
 */
class PhotographyController extends FOSRestController
{
    /**
     * action used for retrieving photography timeline
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function photographyTimelineAction()
    {
        $response = new Response(
            $this->get('deepmikoto.api.photography_manager')->getPhotographyTimeline(),
            200
        );
        $response->headers->set( 'Content-Type', 'application/json' );
        /** 7 days */
        $response->setSharedMaxAge( 604800 );
        $response->setMaxAge( 0 );

        return $response;
    }

    /**
     * action used for retrieving photography post
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function photographyPostAction( Request $request )
    {
        $id = $request->get( 'id', null );
        $slug = $request->get( 'slug', null );
        $response = new Response(
            $this->get('deepmikoto.api.photography_manager')->getPhotographyPost( $id, $slug ),
            200
        );
        $response->headers->set( 'Content-Type', 'application/json' );
        /** 7 days */
        $response->setSharedMaxAge( 604800 );
        $response->setMaxAge( 0 );

        return $response;
    }
}