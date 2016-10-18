<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 9/27/2015
 * Time: 14:42
 */

namespace DeepMikoto\ApiBundle\Controller;


use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CodingController
 *
 * @package DeepMikoto\ApiBundle\Controller
 */
class CodingController extends Controller
{
    /**
     * action used for retrieving coding timeline
     *
     * @param Request $request
     * @return Response
     */
    public function codingTimelineAction( Request $request )
    {
        $limit = $request->get( 'limit', 20 );
        $offset = $request->get( 'offset', 0 );
        $response = new Response(
            $this->get('deepmikoto.api.coding_manager')->getCodingTimeline( $limit, $offset ),
            200
        );
        $response->headers->set( 'Content-Type', 'application/json' );
        /** 7 days */
        $response->setSharedMaxAge( 604800 );
        $response->setMaxAge( 0 );

        return $response;
    }

    /**
     * @return Response
     */
    public function codingCategoriesAction()
    {
        $response = new Response(
            $this->get('deepmikoto.api.coding_manager')->getCodingCategories(),
            200
        );
        $response->headers->set( 'Content-Type', 'application/json' );
        /** 7 days */
        $response->setSharedMaxAge( 604800 );
        $response->setMaxAge( 0 );

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function codingCategoryTimelineAction( Request $request )
    {
        $category = null;
        $requestedCategory = $request->get('category');
        if ( !( $requestedCategory != null &&
            ( $category = $this->getDoctrine()->getRepository('DeepMikotoApiBundle:CodingCategory')->findOneBy([
                'slug' => $requestedCategory
            ]) ) != null )
        ) {
            throw $this->createNotFoundException();
        }
        $response = new Response(
            $this->get('deepmikoto.api.coding_manager')->getCodingCategoryTimeline( $category ),
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
            $this->get('deepmikoto.api.coding_manager')->getCodingPost( $id, $slug, $request ),
            200
        );
        $response->headers->set( 'Content-Type', 'application/json' );
        /** 2 days */
        /*$response->setSharedMaxAge( 172800 );
        $response->setMaxAge( 0 );*/

        return $response;
    }
} 