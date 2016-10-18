<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 7/21/2015
 * Time: 20:20
 */

namespace DeepMikoto\ApiBundle\Controller;


use DeepMikoto\ApiBundle\Entity\CodingCategory;
use DeepMikoto\ApiBundle\Entity\CodingPost;
use DeepMikoto\ApiBundle\Entity\GamingPost;
use DeepMikoto\ApiBundle\Entity\PhotographyPost;
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
            $this->render('@DeepMikotoApi/App/landing.html.twig')->getContent(),
            200
        );
        /** 90 days */
        $response->setSharedMaxAge( 7776000 );
        $response->setMaxAge( 0 );

        return $response;
    }

    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function codingAction()
    {
        $response = new Response(
            $this->render('@DeepMikotoApi/App/coding.html.twig')->getContent(),
            200
        );
        /** 90 days */
        $response->setSharedMaxAge( 7776000 );
        $response->setMaxAge( 0 );

        return $response;
    }

    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function gamingAction()
    {
        $response = new Response(
            $this->render('@DeepMikotoApi/App/gaming.html.twig')->getContent(),
            200
        );
        /** 90 days */
        $response->setSharedMaxAge( 7776000 );
        $response->setMaxAge( 0 );

        return $response;
    }

    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function photographyAction()
    {
        $response = new Response(
            $this->render('@DeepMikotoApi/App/photography.html.twig')->getContent(),
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
     * @return Response
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

    /**
     * gaming post details page
     *
     * @param $id
     * @param $slug
     * @return Response
     */
    public function gamingPostAction( $id, $slug )
    {
        $em = $this->getDoctrine()->getManager();
        $gamingPost = $em->getRepository( 'DeepMikotoApiBundle:GamingPost')->findOneBy([
            'id'    => $id,
            'slug'  => $slug,
            'public'=> true
        ]);
        if( !$gamingPost ) throw $this->createNotFoundException();
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
     * @return Response
     */
    public function codingPostAction( $id, $slug )
    {
        $em = $this->getDoctrine()->getManager();
        $codingPost = $em->getRepository( 'DeepMikotoApiBundle:CodingPost')->findOneBy([
            'id'    => $id,
            'slug'  => $slug,
            'public'=> true
        ]);
        if( !$codingPost ) throw $this->createNotFoundException();
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
     * coding posts by category
     *
     * @param $category
     * @return Response
     */
    public function codingPostsByCategoryAction( $category )
    {
        $em = $this->getDoctrine()->getManager();
        /** @var CodingCategory $codingCategory */
        $codingCategory = $em->getRepository( 'DeepMikotoApiBundle:CodingCategory')->findOneBy([
            'slug'  => $category,
        ]);
        if( !$codingCategory ) throw $this->createNotFoundException();
        $response = new Response(
            $this->render( 'DeepMikotoApiBundle:App:coding_posts_by_category.html.twig',[ 'category' => [
                'name' => $codingCategory->getName(),
                'slug' => $codingCategory->getSlug(),
                'image' => $codingCategory->getWebPath()
            ] ] )->getContent(),
            200
        );
        /** 90 days */
        $response->setSharedMaxAge( 7776000 );
        $response->setMaxAge( 0 );

        return $response;
    }

    /**
     *
     * @return Response
     */
    public function codingCategoriesAction()
    {
        $response = new Response(
            $this->render('@DeepMikotoApi/App/coding.html.twig')->getContent(),
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
            $this->render('@DeepMikotoApi/App/help.html.twig')->getContent(),
            200
        );
        /** 90 days */
        $response->setSharedMaxAge( 7776000 );
        $response->setMaxAge( 0 );

        return $response;
    }
} 