<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 12/29/2015
 * Time: 06:42
 */

namespace DeepMikoto\ApiBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GamingController
 * @package DeepMikoto\ApiBundle\Controller
 */
class GamingController extends Controller
{
    /**
     * action used for retrieving gaming timeline
     *
     * @param Request $request
     * @return Response
     */
    public function gamingTimelineAction( Request $request )
    {
        $limit = $request->get( 'limit', 10 );
        $offset = $request->get( 'offset', 0 );
        $response = new Response(
            $this->get('deepmikoto.api.gaming_manager')->getGamingTimeline( $limit, $offset ),
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
            $this->get('deepmikoto.api.gaming_manager')->getGamingPost( $id, $slug, $request ),
            200
        );
        $response->headers->set( 'Content-Type', 'application/json' );
        /** 2 days */
        /*$response->setSharedMaxAge( 172800 );
        $response->setMaxAge( 0 );*/

        return $response;
    }
}