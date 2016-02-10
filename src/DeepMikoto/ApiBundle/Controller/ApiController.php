<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 6/6/2015
 * Time: 14:07
 */

namespace DeepMikoto\ApiBundle\Controller;


use DeepMikoto\ApiBundle\Entity\StaticPage;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Handles api routes
 *
 * Class ApiController
 * @package DeepMikoto\ApiBundle\Controller
 */
class ApiController extends FOSRestController
{
    /**
     * Api templates
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function templatesAction()
    {
        $response = new Response( $this->get('deepmikoto.api.templating')->compileTemplates(), 200 );
        /** 90 days */
        $response->setSharedMaxAge( 7776000 );
        $response->setMaxAge( 0 );
        $response->headers->set( 'Content-Type', 'application/json' );

        return $response;
    }

    /**
     * static pages ( i.e. Help page )
     *
     */
    public function helpPageAction()
    {
        /** @var StaticPage $helpPage */
        $helpPage = $this->getDoctrine()->getManager()->getRepository( 'DeepMikotoApiBundle:StaticPage' )->findOneBy( [ 'name' => 'help' ] );
        if( $helpPage === null )
            throw $this->createNotFoundException();

        $response = new JsonResponse( [ 'content' => $helpPage->getContent(), 'updated' => $helpPage->getModified()->format( 'M jS, Y' ) ], 200 );
        /** 90 days */
        $response->setSharedMaxAge( 7776000 );
        $response->setMaxAge( 0 );
        $response->headers->set( 'Content-Type', 'application/json' );

        return $response;
    }
}