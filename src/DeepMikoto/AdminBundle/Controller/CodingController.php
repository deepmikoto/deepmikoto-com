<?php

namespace DeepMikoto\AdminBundle\Controller;

use DeepMikoto\ApiBundle\Entity\CodingPost;
use DeepMikoto\ApiBundle\Entity\SidebarPrimaryBlock;
use DeepMikoto\ApiBundle\Form\EditCodingPostType;
use DeepMikoto\ApiBundle\Form\NewCodingPostType;
use DeepMikoto\ApiBundle\Form\SidebarPrimaryBlockType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CodingController
 *
 * @package DeepMikoto\AdminBundle\Controller
 */
class CodingController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('DeepMikotoAdminBundle:Coding:index.html.twig');
    }

    /**
     * Coding sidebar primary block form
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function primaryBlockAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $sidebarPrimaryBlock = $em->getRepository( 'DeepMikotoApiBundle:SidebarPrimaryBlock' )->findOneBy(
            [ 'type' => 'coding']
        );
        $sidebarPrimaryBlock == null ? $sidebarPrimaryBlock = new SidebarPrimaryBlock() : null ;
        $form = $this->createForm( new SidebarPrimaryBlockType(), $sidebarPrimaryBlock );
        if( $request-> isMethod( 'POST' ) ){
            $form->handleRequest( $request );
            if( $form->isValid() ){
                $sidebarPrimaryBlock->setType( 'coding' );
                $em->persist( $sidebarPrimaryBlock );
                $em->flush( $sidebarPrimaryBlock );
                $this->addFlash( 'success', '<strong>Awesome!</strong> You updated the coding primary block!' );

                return $this->redirectToRoute( 'deepmikoto_admin_coding_primary_block' );
            }
        }
        if( $sidebarPrimaryBlock->getPicture() != null ){
            $picturePath = $this->container->get('liip_imagine.cache.manager')->getBrowserPath( 'images/api/' . $sidebarPrimaryBlock->getPicture(), 'sidebar_primary_block');
        } else {
            $picturePath = null;
        }

        return $this->render('DeepMikotoAdminBundle:Parts:primary_block_form.html.twig', [ 'form' => $form->createView(), 'picture' => $picturePath, 'type' => 'coding' ]);
    }

    /**
     * New coding post form
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newPostAction( Request $request )
    {
        $em = $this->getDoctrine()->getManager();
        $codingPost = new CodingPost();
        $form = $this->createForm( new NewCodingPostType(), $codingPost );
        if( $request-> isMethod( 'POST' ) ){
            $form->handleRequest( $request );
            if( $form->isValid() ){
                $em->persist( $codingPost );
                $em->flush( $codingPost );
                $this->addFlash(
                    'success',
                    '<strong>Awesome!</strong> You created a new coding post! It is now <strong>drafted</strong>. Review it and make it public!'
                );

                return $this->redirectToRoute( 'deepmikoto_admin_coding_new_post' );
            }
        }

        return $this->render( 'DeepMikotoAdminBundle:Coding:new.html.twig', [ 'form' => $form->createView() ] );
    }

    /**
     * edit coding post form
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editPostAction( Request $request, $id )
    {
        $em = $this->getDoctrine()->getManager();
        /** @var \DeepMikoto\ApiBundle\Entity\CodingPost $codingPost */
        $codingPost = $em->find( 'DeepMikotoApiBundle:CodingPost', $id );
        $codingPost == null ? $this->createNotFoundException() : null;
        $form = $this->createForm( new EditCodingPostType(), $codingPost );
        if( $request-> isMethod( 'POST' ) ){
            $form->handleRequest( $request );
            if( $form->isValid() ){
                $em->persist( $codingPost );
                $em->flush( $codingPost );
                $this->addFlash( 'success', '<strong>Awesome!</strong> Editing successfull' );

                return $this->redirectToRoute( 'deepmikoto_admin_coding_edit_post', [
                    'id' => $codingPost->getId()
                ]);
            }
        }

        return $this->render( 'DeepMikotoAdminBundle:Coding:edit.html.twig', [ 'form' => $form->createView() ] );
    }

    /**
     * submitted coding posts
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function submittedPostsAction()
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository( 'DeepMikotoApiBundle:CodingPost' )->createQueryBuilder( 'p' );
        $query
            ->select( 'p.id, p.title, p.date' )
            ->where( 'p.public = 1' )
            ->orderBy( 'p.date', 'DESC' )
        ;
        $posts = $query->getQuery()->getResult();

        return $this->render( 'DeepMikotoAdminBundle:Coding:submitted_posts.html.twig', [ 'posts' => $posts ] );
    }

    /**
     * drafted coding posts
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function draftedPostsAction()
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository( 'DeepMikotoApiBundle:CodingPost' )->createQueryBuilder( 'p' );
        $query
            ->select( 'p.id, p.title, p.date' )
            ->where( 'p.public = 0' )
            ->orderBy( 'p.date', 'DESC' )
        ;
        $posts = $query->getQuery()->getResult();

        return $this->render( 'DeepMikotoAdminBundle:Coding:drafted_posts.html.twig', [ 'posts' => $posts ] );
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
        /** @var \DeepMikoto\ApiBundle\Entity\CodingPost $codingPost */
        $codingPost = $em->find( 'DeepMikotoApiBundle:CodingPost', $id );
        $codingPost->setPublic( $public );
        $em->persist( $codingPost );
        $em->flush( $codingPost );
        $this->addFlash( 'success', '<strong>Awesome!</strong> You changed the status of <strong>' .
            $codingPost->getTitle() . '</strong> to <strong>' . ( $public ? 'public' : 'drafted' ) . '</strong>' )
        ;

        return $this->redirectToRoute( $public ? 'deepmikoto_admin_coding_submitted_posts' : 'deepmikoto_admin_coding_drafted_posts');
    }
}
