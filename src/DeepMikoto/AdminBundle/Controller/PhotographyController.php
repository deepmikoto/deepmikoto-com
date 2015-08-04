<?php

namespace DeepMikoto\AdminBundle\Controller;

use DeepMikoto\ApiBundle\Entity\PhotographyPost;
use DeepMikoto\ApiBundle\Entity\PhotographyPostPhoto;
use DeepMikoto\ApiBundle\Entity\SidebarPrimaryBlock;
use DeepMikoto\ApiBundle\Form\EditPhotographyPostType;
use DeepMikoto\ApiBundle\Form\NewPhotographyPostType;
use DeepMikoto\ApiBundle\Form\PhotographyPostPhotoType;
use DeepMikoto\ApiBundle\Form\SidebarPrimaryBlockType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PhotographyController
 *
 * @package DeepMikoto\AdminBundle\Controller
 */
class PhotographyController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('DeepMikotoAdminBundle:Photography:index.html.twig');
    }

    /**
     * Photography sidebar primary block form
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function primaryBlockAction( Request $request )
    {
        $em = $this->getDoctrine()->getManager();
        $sidebarPrimaryBlock = $em->getRepository( 'DeepMikotoApiBundle:SidebarPrimaryBlock' )->findOneBy(
            [ 'type' => 'photography']
        );
        $sidebarPrimaryBlock == null ? $sidebarPrimaryBlock = new SidebarPrimaryBlock() : null ;
        $form = $this->createForm( new SidebarPrimaryBlockType(), $sidebarPrimaryBlock );
        if( $request-> isMethod( 'POST' ) ){
            $form->handleRequest( $request );
            if( $form->isValid() ){
                $sidebarPrimaryBlock->setType( 'photography' );
                $em->persist( $sidebarPrimaryBlock );
                $em->flush( $sidebarPrimaryBlock );
                $this->addFlash( 'success', '<strong>Awesome!</strong> You updated the photography primary block!' );

                return $this->redirectToRoute( 'deepmikoto_admin_photography_primary_block' );
            }
        }
        if( $sidebarPrimaryBlock->getPicture() != null ){
            $picturePath = $this->container->get('liip_imagine.cache.manager')->getBrowserPath( 'images/api/' . $sidebarPrimaryBlock->getPicture(), 'sidebar_primary_block');
        } else {
            $picturePath = null;
        }

        return $this->render('DeepMikotoAdminBundle:Parts:primary_block_form.html.twig', [ 'form' => $form->createView(), 'picture' => $picturePath, 'type' => 'photography' ]);
    }

    /**
     * New photography post form
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newPostAction( Request $request )
    {
        $em = $this->getDoctrine()->getManager();
        $photographyPost = new PhotographyPost();
        $form = $this->createForm( new NewPhotographyPostType(), $photographyPost );
        if( $request-> isMethod( 'POST' ) ){
            $form->handleRequest( $request );
            if( $form->isValid() ){
                $em->persist( $photographyPost );
                $em->flush( $photographyPost );
                $this->addFlash( 'success', '<strong>Awesome!</strong> You created a new photography post! It is now <strong>drafted</strong>. Add photos to it and make it public!' );

                return $this->redirectToRoute( 'deepmikoto_admin_photography_new_post' );
            }
        }

        return $this->render( 'DeepMikotoAdminBundle:Photography:new.html.twig', [ 'form' => $form->createView() ] );
    }

    /**
     * edit photography post form
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editPostAction( Request $request, $id )
    {
        $em = $this->getDoctrine()->getManager();
        /** @var \DeepMikoto\ApiBundle\Entity\PhotographyPost $photographyPost */
        $photographyPost = $em->find( 'DeepMikotoApiBundle:PhotographyPost', $id );
        $photographyPost == null ? $this->createNotFoundException() : null;
        $form = $this->createForm( new EditPhotographyPostType(), $photographyPost );
        if( $request-> isMethod( 'POST' ) ){
            $form->handleRequest( $request );
            if( $form->isValid() ){
                $em->persist( $photographyPost );
                $em->flush( $photographyPost );
                $this->addFlash( 'success', '<strong>Awesome!</strong> Editing successfull' );

                return $this->redirectToRoute( 'deepmikoto_admin_photography_edit_post', [
                    'id' => $photographyPost->getId()
                ]);
            }
        }

        return $this->render( 'DeepMikotoAdminBundle:Photography:edit.html.twig', [ 'form' => $form->createView() ] );
    }

    /**
     * New photography post photo form
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newPostPhotoAction( Request $request )
    {
        $em = $this->getDoctrine()->getManager();
        $photographyPostPhoto = new PhotographyPostPhoto();
        $form = $this->createForm( new PhotographyPostPhotoType(), $photographyPostPhoto );
        if( $request-> isMethod( 'POST' ) ){
            $form->handleRequest( $request );
            if( $form->isValid() ){
                $em->persist( $photographyPostPhoto );
                $em->flush( $photographyPostPhoto );
                $this->addFlash( 'success', '<strong>Awesome!</strong> You created a new photography post photo!' );

                return $this->redirectToRoute( 'deepmikoto_admin_photography_new_post_photo' );
            }
        }

        return $this->render('DeepMikotoAdminBundle:Photography:new_photo.html.twig', [ 'form' => $form->createView() ]);
    }

    /**
     * edit photography post photo form
     *
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editPostPhotoAction( Request $request, $id )
    {
        $em = $this->getDoctrine()->getManager();
        $photographyPostPhoto = $em->find( 'DeepMikotoApiBundle:PhotographyPostPhoto', $id );
        if( !$photographyPostPhoto instanceof PhotographyPostPhoto )
            return $this->createNotFoundException( 'Provided id does not exist in the database ');
        $form = $this->createForm( new PhotographyPostPhotoType(), $photographyPostPhoto );
        if( $request-> isMethod( 'POST' ) ){
            $form->handleRequest( $request );
            if( $form->isValid() ){
                $em->persist( $photographyPostPhoto );
                $em->flush( $photographyPostPhoto );
                $this->addFlash( 'success', '<strong>Awesome!</strong> You updated the photography post photo!' );

                return $this->redirectToRoute( 'deepmikoto_admin_photography_edit_post_photo' );
            }
        }

        return $this->render('DeepMikotoAdminBundle:Photography:edit_photo.html.twig', [ 'form' => $form->createView() ]);
    }

    /**
     * photography post photo list
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postPhotoListAction()
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository( 'DeepMikotoApiBundle:PhotographyPostPhoto' )->createQueryBuilder( 'p' );
        $query
            ->select( 'p.id, p.path, pp.title as associatedPost, p.date' )
            ->leftJoin( 'p.photographyPost', 'pp', 'WITH', 'pp.id = p.photographyPost' )
            ->orderBy( 'p.date', 'DESC' )
        ;
        $photos = $query->getQuery()->getResult();

        return $this->render( 'DeepMikotoAdminBundle:Photography:photo_list.html.twig', [ 'photos' => $photos ] );
    }

    /**
     * submitted photography posts
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function submittedPostsAction()
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository( 'DeepMikotoApiBundle:PhotographyPost' )->createQueryBuilder( 'p' );
        $query
            ->select( 'p.id, p.title, p.date' )
            ->where( 'p.public = 1' )
            ->orderBy( 'p.date', 'DESC' )
        ;
        $posts = $query->getQuery()->getResult();

        return $this->render( 'DeepMikotoAdminBundle:Photography:submitted_posts.html.twig', [ 'posts' => $posts ] );
    }

    /**
     * drafted photography posts
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function draftedPostsAction()
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository( 'DeepMikotoApiBundle:PhotographyPost' )->createQueryBuilder( 'p' );
        $query
            ->select( 'p.id, p.title, p.date' )
            ->where( 'p.public = 0' )
            ->orderBy( 'p.date', 'DESC' )
        ;
        $posts = $query->getQuery()->getResult();

        return $this->render( 'DeepMikotoAdminBundle:Photography:drafted_posts.html.twig', [ 'posts' => $posts ] );
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
        /** @var \DeepMikoto\ApiBundle\Entity\PhotographyPost $photographyPost */
        $photographyPost = $em->find( 'DeepMikotoApiBundle:PhotographyPost', $id );
        $photographyPost->setPublic( $public );
        $em->persist( $photographyPost );
        $em->flush( $photographyPost );
        $this->addFlash( 'success', '<strong>Awesome!</strong> You changed the status of <strong>' .
            $photographyPost->getTitle() . '</strong> to <strong>' . ( $public ? 'public' : 'drafted' ) . '</strong>' )
        ;

        return $this->redirectToRoute( $public ? 'deepmikoto_admin_photography_submitted_posts' : 'deepmikoto_admin_photography_drafted_posts');
    }
}
