<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 7/21/2015
 * Time: 20:20
 */

namespace DeepMikoto\ApiBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * handles app routes
 *
 * Class AppController
 * @package DeepMikoto\ApiBundle\Controller
 */
class AppController extends Controller
{
    /**
     * App homepage
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction()
    {
        $response = new Response(
            $this->render('DeepMikotoApiBundle:App:index.html.twig')->getContent(),
            200
        );
        /** 90 days */
        $response->setSharedMaxAge( 7776000 );
        $response->setMaxAge( 0 );

        return $response;
    }

    /**
     * photography post details page
     *
     * @param $id
     * @param $slug
     * @param Request $request
     * @return Response
     */
    public function photographyPostAction( $id, $slug, Request $request )
    {
        $em = $this->getDoctrine()->getManager();
        $photographyPost = $em->getRepository( 'DeepMikotoApiBundle:PhotographyPost')->findOneBy([
            'id'    => $id,
            'slug'  => $slug,
            'public'=> true
        ]);
        if( !$photographyPost ) throw $this->createNotFoundException();
        $this->get( 'deepmikoto.api.tracking_manager' )->addPostView( $photographyPost, $request );
        $response = new Response(
            $this->render( 'DeepMikotoApiBundle:App:photography_post.html.twig',[ 'post' => $photographyPost ] )->getContent(),
            200
        );
        /** 90 days */
        $response->setSharedMaxAge( 7776000 );
        $response->setMaxAge( 0 );

        return $response;
    }

    /**
     * gaming post details page
     *
     * @param $id
     * @param $slug
     * @param Request $request
     * @return Response
     */
    public function gamingPostAction( $id, $slug, Request $request )
    {
        $em = $this->getDoctrine()->getManager();
        $gamingPost = $em->getRepository( 'DeepMikotoApiBundle:GamingPost')->findOneBy([
            'id'    => $id,
            'slug'  => $slug,
            'public'=> true
        ]);
        if( !$gamingPost ) throw $this->createNotFoundException();
        $this->get( 'deepmikoto.api.tracking_manager' )->addPostView( $gamingPost, $request );
        $response = new Response(
            $this->render( 'DeepMikotoApiBundle:App:gaming_post.html.twig',[ 'post' => $gamingPost ] )->getContent(),
            200
        );
        /** 90 days */
        $response->setSharedMaxAge( 7776000 );
        $response->setMaxAge( 0 );

        return $response;
    }

    /**
     * coding post details page
     *
     * @param $id
     * @param $slug
     * @param Request $request
     * @return Response
     */
    public function codingPostAction( $id, $slug, Request $request )
    {
        $em = $this->getDoctrine()->getManager();
        $codingPost = $em->getRepository( 'DeepMikotoApiBundle:CodingPost')->findOneBy([
            'id'    => $id,
            'slug'  => $slug,
            'public'=> true
        ]);
        if( !$codingPost ) throw $this->createNotFoundException();
        $this->get( 'deepmikoto.api.tracking_manager' )->addPostView( $codingPost, $request );
        $response = new Response(
            $this->render( 'DeepMikotoApiBundle:App:coding_post.html.twig',[ 'post' => $codingPost ] )->getContent(),
            200
        );
        /** 90 days */
        $response->setSharedMaxAge( 7776000 );
        $response->setMaxAge( 0 );

        return $response;
    }

    /**
     * static pages ( i.e. Help page )
     *
     * @return Response
     */
    public function helpPageAction()
    {
        if( $this->getDoctrine()->getManager()->getRepository( 'DeepMikotoApiBundle:StaticPage' )->findBy( [ 'name' => 'help' ] ) === null )
            throw $this->createNotFoundException();

        $response = new Response( // todo: add a separate help page template with metadata
            $this->render('@DeepMikotoApi/App/index.html.twig')->getContent(),
            200
        );
        /** 90 days */
        $response->setSharedMaxAge( 7776000 );
        $response->setMaxAge( 0 );

        return $response;
    }
} 