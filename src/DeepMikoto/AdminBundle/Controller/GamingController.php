<?php

namespace DeepMikoto\AdminBundle\Controller;

use DeepMikoto\ApiBundle\Entity\GamingPost;
use DeepMikoto\ApiBundle\Entity\SidebarPrimaryBlock;
use DeepMikoto\ApiBundle\Form\GamingPostType;
use DeepMikoto\ApiBundle\Form\SidebarPrimaryBlockType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GamingController
 *
 * @package DeepMikoto\AdminBundle\Controller
 */
class GamingController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('DeepMikotoAdminBundle:Gaming:index.html.twig');
    }

    /**
     * Gaming sidebar primary block form
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function primaryBlockAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $sidebarPrimaryBlock = $em->getRepository( 'DeepMikotoApiBundle:SidebarPrimaryBlock' )->findOneBy(
            [ 'type' => 'gaming']
        );
        $sidebarPrimaryBlock == null ? $sidebarPrimaryBlock = new SidebarPrimaryBlock() : null ;
        $form = $this->createForm( SidebarPrimaryBlockType::class, $sidebarPrimaryBlock );
        if( $request-> isMethod( 'POST' ) ){
            $form->handleRequest( $request );
            if( $form->isValid() ){
                $sidebarPrimaryBlock->setType( 'gaming' );
                $em->persist( $sidebarPrimaryBlock );
                $em->flush( $sidebarPrimaryBlock );
                $this->addFlash( 'success', '<strong>Awesome!</strong> You updated the gaming primary block!' );

                return $this->redirectToRoute( 'deepmikoto_admin_gaming_primary_block' );
            }
        }
        if( $sidebarPrimaryBlock->getPicture() != null ){
            $picturePath = $this->container->get('liip_imagine.cache.manager')->getBrowserPath( $sidebarPrimaryBlock->getWebPath(), 'sidebar_primary_block');
        } else {
            $picturePath = null;
        }

        return $this->render('DeepMikotoAdminBundle:Parts:primary_block_form.html.twig', [ 'form' => $form->createView(), 'picture' => $picturePath, 'type' => 'gaming' ]);
    }

    /**
     * New gaming post form
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newPostAction( Request $request )
    {
        $em = $this->getDoctrine()->getManager();
        $gamingPost = new GamingPost();
        $form = $this->createForm( GamingPostType::class, $gamingPost );
        if( $request-> isMethod( 'POST' ) ){
            $form->handleRequest( $request );
            if( $form->isValid() ){
                $em->persist( $gamingPost );
                $em->flush( $gamingPost );
                $this->addFlash(
                    'success',
                    '<strong>Awesome!</strong> You created a new gaming post! It is now <strong>drafted</strong>. Review it and make it public!'
                );

                return $this->redirectToRoute( 'deepmikoto_admin_gaming_new_post' );
            }
        }

        return $this->render( 'DeepMikotoAdminBundle:Gaming:new.html.twig', [ 'form' => $form->createView() ] );
    }

    /**
     * edit gaming post form
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editPostAction( Request $request, $id )
    {
        $em = $this->getDoctrine()->getManager();
        /** @var \DeepMikoto\ApiBundle\Entity\GamingPost $gamingPost */
        $gamingPost = $em->find( 'DeepMikotoApiBundle:GamingPost', $id );
        $gamingPost == null ? $this->createNotFoundException() : null;
        $form = $this->createForm( GamingPostType::class, $gamingPost );
        if( $request-> isMethod( 'POST' ) ){
            $form->handleRequest( $request );
            if( $form->isValid() ){
                $em->persist( $gamingPost );
                $em->flush( $gamingPost );
                $this->addFlash( 'success', '<strong>Awesome!</strong> Editing successfull' );

                return $this->redirectToRoute( 'deepmikoto_admin_gaming_edit_post', [
                    'id' => $gamingPost->getId()
                ]);
            }
        }

        return $this->render( 'DeepMikotoAdminBundle:Gaming:edit.html.twig', [ 'form' => $form->createView() ] );
    }

    /**
     * submitted gaming posts
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function submittedPostsAction()
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository( 'DeepMikotoApiBundle:GamingPost' )->findBy([ 'public' => true ], [ 'date' => 'DESC' ] );

        return $this->render( 'DeepMikotoAdminBundle:Gaming:submitted_posts.html.twig', [ 'posts' => $posts ] );
    }

    /**
     * drafted gaming posts
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function draftedPostsAction()
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository( 'DeepMikotoApiBundle:GamingPost' )->findBy([ 'public' => false ], [ 'date' => 'DESC' ] );

        return $this->render( 'DeepMikotoAdminBundle:Gaming:drafted_posts.html.twig', [ 'posts' => $posts ] );
    }

    /**
     * @param $id
     * @param $public
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function makePublicOrDraftedAction( $id, $public )
    {
        $public = $public == 'true';
        $em = $this->getDoctrine()->getManager();
        /** @var \DeepMikoto\ApiBundle\Entity\GamingPost $gamingPost */
        $gamingPost = $em->find( 'DeepMikotoApiBundle:GamingPost', $id );
        $gamingPost->setPublic( $public );
        $em->persist( $gamingPost );
        $em->flush( $gamingPost );
        $this->addFlash( 'success', '<strong>Awesome!</strong> You changed the status of <strong>' .
            $gamingPost->getTitle() . '</strong> to <strong>' . ( $public ? 'public' : 'drafted' ) . '</strong>' )
        ;

        return $this->redirectToRoute( $public ? 'deepmikoto_admin_gaming_submitted_posts' : 'deepmikoto_admin_gaming_drafted_posts');
    }
}
