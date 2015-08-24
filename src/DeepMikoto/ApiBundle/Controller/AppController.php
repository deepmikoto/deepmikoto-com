<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 7/21/2015
 * Time: 20:20
 */

namespace DeepMikoto\ApiBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function photographyPostAction( $id, $slug )
    {
        $em = $this->getDoctrine()->getManager();
        $photographyPost = $em->getRepository( 'DeepMikotoApiBundle:PhotographyPost')->findOneBy([
            'id'    => $id,
            'slug'  => $slug,
            'public'=> true
        ]);
        if( !$photographyPost ) throw $this->createNotFoundException();
        $response = new Response(
            $this->render( 'DeepMikotoApiBundle:App:photography_post.html.twig',[ 'post' => $photographyPost ] )->getContent(),
            200
        );
        /** 90 days */
        $response->setSharedMaxAge( 7776000 );
        $response->setMaxAge( 0 );

        return $response;
    }
} 