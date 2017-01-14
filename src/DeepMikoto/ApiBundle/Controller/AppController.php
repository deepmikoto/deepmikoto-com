<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 7/21/2015
 * Time: 20:20
 */

namespace DeepMikoto\ApiBundle\Controller;


use DeepMikoto\ApiBundle\Entity\CodingCategory;
use DeepMikoto\ApiBundle\Entity\CodingDemoPage;
use DeepMikoto\ApiBundle\Entity\CodingPost;
use DeepMikoto\ApiBundle\Entity\GamingPost;
use DeepMikoto\ApiBundle\Entity\PhotographyPost;
use DeepMikoto\ApiBundle\Entity\PhotographyPostPhoto;
use DeepMikoto\ApiBundle\Entity\StaticPage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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
            $this->render('@DeepMikotoApi/App/landing.html.twig',[
                'meta'  => [
                    'title'         => 'deepmikoto',
                    'description'   => 'Coding Tutorials, Coding Guides, Coding How Tos. Game Walkthroughs, Game Guides, Maps and more. Free Stock Images & Wallpapers.',
                    'url'           => $this->generateUrl( 'deepmikoto_app_homepage', [], UrlGeneratorInterface::ABSOLUTE_URL )
                ]
            ])->getContent(),
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
            $this->render('@DeepMikotoApi/App/coding.html.twig',[
                'meta' => [
                    'title'         => 'Coding',
                    'description'   => 'Coding Tutorials, Guides, How Tos and more',
                    'url'           => $this->generateUrl( 'deepmikoto_app_coding', [], UrlGeneratorInterface::ABSOLUTE_URL ),
                    'image'         => 'images/code.jpg'
                ]
            ])->getContent(),
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
            $this->render('@DeepMikotoApi/App/gaming.html.twig', [
                'meta' => [
                    'title'         => 'Gaming',
                    'description'   => 'Game Walkthroughs, Guides, Maps and more',
                    'url'           => $this->generateUrl( 'deepmikoto_app_gaming', [], UrlGeneratorInterface::ABSOLUTE_URL ),
                    'image'         => 'images/wow.jpg'
                ]
            ])->getContent(),
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
            $this->render('@DeepMikotoApi/App/photography.html.twig', [
                'meta' => [
                    'title'         => 'Photography',
                    'description'   => 'Free Stock Images & Wallpapers',
                    'url'           => $this->generateUrl( 'deepmikoto_app_photography', [], UrlGeneratorInterface::ABSOLUTE_URL ),
                    'image'         => 'images/cluj.jpg'
                ]
            ])->getContent(),
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
        /** @var PhotographyPost $photographyPost */
        $photographyPost = $em->getRepository( 'DeepMikotoApiBundle:PhotographyPost')->findOneBy([
            'id'    => $id,
            'slug'  => $slug,
            'public'=> true
        ]);
        if( !$photographyPost ) throw $this->createNotFoundException();
        $image = null;
        if ( $photographyPost->getPhotos()->count() > 0 ) {
            $image = $photographyPost->getPhotos()->first()->getWebPath();
            /** @var PhotographyPostPhoto $photo */
            foreach ( $photographyPost->getPhotos() as $photo ) {
                if ( $photo->getCover() == true ) {
                    $image = $photo->getWebPath();
                }
            }
        }
        $response = new Response(
            $this->render( 'DeepMikotoApiBundle:App:photography_post.html.twig',[
                'post' => $photographyPost,
                'meta'  => [
                    'title'         => $photographyPost->getTitle(),
                    'description'   => $photographyPost->getLocation() . ' - ' . $photographyPost->getDate()->format('F jS, Y'),
                    'url'           => $this->generateUrl( 'deepmikoto_app_photography_post', [
                        'id'    => $photographyPost->getId(),
                        'slug'  => $photographyPost->getSlug()
                    ], UrlGeneratorInterface::ABSOLUTE_URL ),
                    'image'     => $image
                ]
            ] )->getContent(),
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
        /** @var GamingPost $gamingPost */
        $gamingPost = $em->getRepository( 'DeepMikotoApiBundle:GamingPost')->findOneBy([
            'id'    => $id,
            'slug'  => $slug,
            'public'=> true
        ]);
        if( !$gamingPost ) throw $this->createNotFoundException();
        $response = new Response(
            $this->render( 'DeepMikotoApiBundle:App:gaming_post.html.twig',[
                'post'  => $gamingPost,
                'meta'  => [
                    'title'         => $gamingPost->getTitle(),
                    'description'   => $this->trimContent( $gamingPost->getContent() ),
                    'url'           => $this->generateUrl( 'deepmikoto_app_gaming_post', [
                        'id'    => $gamingPost->getId(),
                        'slug'  => $gamingPost->getSlug()
                    ], UrlGeneratorInterface::ABSOLUTE_URL ),
                    'image'     => $gamingPost->getWebPath()
                ]
            ])->getContent(),
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
        /** @var CodingPost $codingPost */
        $codingPost = $em->getRepository( 'DeepMikotoApiBundle:CodingPost')->findOneBy([
            'id'    => $id,
            'slug'  => $slug,
            'public'=> true
        ]);
        if( !$codingPost ) throw $this->createNotFoundException();
        $response = new Response(
            $this->render( 'DeepMikotoApiBundle:App:coding_post.html.twig',[
                'post' => $codingPost,
                'meta' => [
                    'title'         => $codingPost->getTitle(),
                    'description'   => $this->trimContent( $codingPost->getContent() ),
                    'url'           => $this->generateUrl( 'deepmikoto_app_coding_post', [
                        'id'    => $codingPost->getId(),
                        'slug'  => $codingPost->getSlug()
                    ], UrlGeneratorInterface::ABSOLUTE_URL ),
                    'image'         => 'images/code.jpg'
                ]
            ])->getContent(),
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
            $this->render( 'DeepMikotoApiBundle:App:coding_posts_by_category.html.twig',[
                'meta' => [
                    'title'         => $codingCategory->getName() . ' - Coding Category',
                    'description'   => $codingCategory->getName() . ' tutorials, guides and more',
                    'url'           => $this->generateUrl( 'deepmikoto_app_coding_posts_by_category', [
                        'category'  => $codingCategory->getSlug()
                    ], UrlGeneratorInterface::ABSOLUTE_URL ),
                    'image'         => $codingCategory->getWebPath()
                ]
            ])->getContent(),
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
            $this->render('@DeepMikotoApi/App/coding.html.twig',[
                'meta' => [
                    'title'         => 'Coding Categories',
                    'description'   => 'Explore Coding Categories and discover the right tutorial or guide for you.',
                    'url'           => $this->generateUrl( 'deepmikoto_app_coding', [], UrlGeneratorInterface::ABSOLUTE_URL )
                ]
            ])->getContent(),
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
        /** @var StaticPage $page */
        if( ( $page = $this->getDoctrine()->getManager()->getRepository( 'DeepMikotoApiBundle:StaticPage' )->findOneBy( [
                'name' => 'help'
            ]) ) === null
        )
            throw $this->createNotFoundException();

        $response = new Response(
            $this->render('@DeepMikotoApi/App/help.html.twig', [
                'meta' => [
                    'title'         => 'Help',
                    'description'   => $this->trimContent( $page->getContent() ),
                    'url'           => $this->generateUrl( 'deepmikoto_app_help_page', [], UrlGeneratorInterface::ABSOLUTE_URL )
                ]
            ])->getContent(),
            200
        );
        /** 90 days */
        $response->setSharedMaxAge( 7776000 );
        $response->setMaxAge( 0 );

        return $response;
    }

    /**
     * @param $slug
     * @param Request $request
     * @return Response
     */
    public function codingDemoPageAction($slug, Request $request)
    {
        /** @var  $em */
        $em = $this->getDoctrine()->getManager();
        /** @var CodingDemoPage $codingDemoPage */
        $codingDemoPage = $em->getRepository('DeepMikotoApiBundle:CodingDemoPage')->findOneBy([ 'slug' => $slug ]);
        if ($codingDemoPage == null || $codingDemoPage->getCodingPost() == null ) throw $this->createNotFoundException();
        $codingPost = $codingDemoPage->getCodingPost();
        $this->get('deepmikoto.api.tracking_manager')->addPostView($codingDemoPage, $request);

        return $this->render('@DeepMikotoApi/App/coding_demo_page.html.twig', [
            'overrideLayout' => 'coding_demo_',
            'post'  => $codingPost,
            'style' => $codingDemoPage->getStyle(),
            'html'  => $codingDemoPage->getHtml(),
            'js'    => $codingDemoPage->getJs(),
            'meta'  => [
                'title'         => $codingDemoPage->getTitle(),
                'description'   => "Demo page for '" . $codingPost->getTitle() . "' article",
                'url'           => $this->generateUrl( 'deepmikoto_app_coding_demo_page', [
                    'slug'  => $codingPost->getSlug()
                ], UrlGeneratorInterface::ABSOLUTE_URL ),
                'image'         => 'images/code.jpg'
            ]
        ]);
    }

    /**
     * trim a post's content and return a text-only value
     *
     * @param string $content
     * @param int $limit
     * @return string
     */
    public function trimContent( $content, $limit = 250 )
    {
        $content = trim( strip_tags( $content ) );
        $content = htmlspecialchars_decode( $content, ENT_QUOTES );
        if( strlen( $content ) > $limit ){
            $pos = strpos( $content . ' ', ' ', $limit );
            $content = rtrim( substr( $content, 0, $pos ) ) . ' ...';
            if( strpos( $content, '&nbsp;' ) == 0 ){
                $content =  preg_replace( '/&nbsp;/', '', $content, 1 );
            }
        }

        return trim( preg_replace( '/\s+/', ' ', $content ) );
    }
} 