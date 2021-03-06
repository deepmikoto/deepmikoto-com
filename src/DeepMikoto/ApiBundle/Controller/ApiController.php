<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 6/6/2015
 * Time: 14:07
 */

namespace DeepMikoto\ApiBundle\Controller;


use DeepMikoto\ApiBundle\Entity\StaticPage;
use DeepMikoto\ApiBundle\Security\ApiResponseStatus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Handles api routes
 *
 * Class ApiController
 * @package DeepMikoto\ApiBundle\Controller
 */
class ApiController extends Controller
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

        $response = new JsonResponse( [
            'content' => $helpPage->getContent(), 'updated' => $helpPage->getModified()->format( 'M jS, Y' )
        ], 200 );
        /** 90 days */
        $response->setSharedMaxAge( 7776000 );
        $response->setMaxAge( 0 );
        $response->headers->set( 'Content-Type', 'application/json' );

        return $response;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function searchSuggestionsAction( Request $request )
    {
        $term = $request->get('term', '' );
        if ( strlen( $term  ) >= 2 ) {
            $codingSuggestions = $this->get('deepmikoto.api.coding_manager')->getSuggestions( $term );
            $gamingSuggestions = $this->get('deepmikoto.api.gaming_manager')->getSuggestions( $term );
            $photographySuggestions = $this->get('deepmikoto.api.photography_manager')->getSuggestions( $term );
            $suggestions = [];
            $suggestionsLimit = 5;
            for ( $i = 0; $i < $suggestionsLimit; $i++ ) {
                if( count( $suggestions ) < $suggestionsLimit && isset( $codingSuggestions[ $i ] ) ) {
                    $suggestions[] = $codingSuggestions[ $i ];
                }
                if( count( $suggestions ) < $suggestionsLimit && isset( $gamingSuggestions[ $i ] ) ) {
                    $suggestions[] = $gamingSuggestions[ $i ];
                }
                if( count( $suggestions ) < $suggestionsLimit && isset( $photographySuggestions[ $i ] ) ) {
                    $suggestions[] = $photographySuggestions[ $i ];
                }
            }
        } else {
            $suggestions = [];
        }
        $response = new JsonResponse( [
            'payload'   => $suggestions,
            'response'  => ApiResponseStatus::$ALL_OK
        ], 200 );
        /** 90 days */
        $response->setSharedMaxAge( 7776000 );
        $response->setMaxAge( 0 );

        return $response;
    }
}