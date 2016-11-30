<?php

namespace DeepMikoto\AdminBundle\Controller;

use DeepMikoto\ApiBundle\Entity\CodingCategory;
use DeepMikoto\ApiBundle\Entity\CodingPost;
use DeepMikoto\ApiBundle\Entity\SidebarPrimaryBlock;
use DeepMikoto\ApiBundle\Form\CodingCategoryType;
use DeepMikoto\ApiBundle\Form\CodingPostType;
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
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $sidebarPrimaryBlock = $em->getRepository( 'DeepMikotoApiBundle:SidebarPrimaryBlock' )->findOneBy(
            [ 'type' => 'coding']
        );
        $sidebarPrimaryBlock == null ? $sidebarPrimaryBlock = new SidebarPrimaryBlock() : null ;
        $form = $this->createForm( SidebarPrimaryBlockType::class, $sidebarPrimaryBlock );
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

        return $this->render('@DeepMikotoAdmin/Parts/primary_block_form.html.twig', [ 'form' => $form->createView(), 'picture' => $picturePath, 'type' => 'coding' ]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function deletePostAction( $id )
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $post = $em->find('DeepMikotoApiBundle:CodingPost', intval( $id ) );
        if ( $post == null ) {
            throw $this->createNotFoundException();
        }
        $em->remove( $post );
        $em->flush();
        $this->addFlash('success', 'Post successfully deleted!');

        return $this->redirectToRoute('deepmikoto_admin_coding_drafted_posts');
    }

    /**
     * New coding post form
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newPostAction( Request $request )
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $codingPost = new CodingPost();
        $form = $this->createForm( CodingPostType::class, $codingPost );
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

        return $this->render( '@DeepMikotoAdmin/Coding/new.html.twig', [ 'form' => $form->createView() ] );
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
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var \DeepMikoto\ApiBundle\Entity\CodingPost $codingPost */
        $codingPost = $em->find( 'DeepMikotoApiBundle:CodingPost', $id );
        $codingPost == null ? $this->createNotFoundException() : null;
        $form = $this->createForm( CodingPostType::class, $codingPost );
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

        return $this->render( '@DeepMikotoAdmin/Coding/edit.html.twig', [ 'form' => $form->createView() ] );
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

        return $this->render( '@DeepMikotoAdmin/Coding/submitted_posts.html.twig', [ 'posts' => $posts ] );
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

        return $this->render( '@DeepMikotoAdmin/Coding/drafted_posts.html.twig', [ 'posts' => $posts ] );
    }

    /**
     * @param $id
     * @param $public
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function makePublicOrDraftedAction( $id, $public )
    {
        $public = $public == 'true';
        /** @var \Doctrine\ORM\EntityManager $em */
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

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoriesAction()
    {
        $categories = $this->getDoctrine()->getManager()->getRepository('DeepMikotoApiBundle:CodingCategory')->findBy( [], [ 'name' => 'ASC' ] );

        return $this->render('@DeepMikotoAdmin/Coding/categories.html.twig', [ 'categories' => $categories ] );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addCategoryAction(Request $request)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $category = new CodingCategory();
        $form = $this->createForm( CodingCategoryType::class, $category );
        if( $request->isMethod( 'POST' ) ){
            $form->handleRequest( $request );
            if( $form->isValid() ){
                $em->persist( $category );
                $em->flush( $category );
                $this->addFlash('success', '<strong>Awesome!</strong>You created a new Coding Category');

                return $this->redirectToRoute('deepmikoto_admin_coding_categories');
            }
        }

        return $this->render('@DeepMikotoAdmin/Coding/new_or_edit_category.html.twig', [ 'form' => $form->createView(), 'picture' => null ] );
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response|\Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function editCategoryAction( $id, Request $request )
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $category = $em->find( 'DeepMikotoApiBundle:CodingCategory', $id );
        if( $category == null ) return $this->createNotFoundException( 'Not Found!' );
        $form = $this->createForm( CodingCategoryType::class, $category );
        if( $request->isMethod( 'POST' ) ){
            $form->handleRequest( $request );
            if( $form->isValid() ){
                $em->persist( $category );
                $em->flush( $category );
                $this->addFlash('success', '<strong>Awesome!</strong>You updated the Coding Category');

                return $this->redirectToRoute( 'deepmikoto_admin_coding_edit_category', [ 'id' => $id ] );
            }
        }

        return $this->render('@DeepMikotoAdmin/Coding/new_or_edit_category.html.twig', [ 'form' => $form->createView(), 'picture' => $category->getWebPath() ] );
    }
}
