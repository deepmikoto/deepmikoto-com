<?php

namespace DeepMikoto\AdminBundle\Controller;

use DeepMikoto\ApiBundle\Entity\SidebarPrimaryBlock;
use DeepMikoto\ApiBundle\Entity\StaticPage;
use DeepMikoto\ApiBundle\Form\SidebarPrimaryBlockType;
use DeepMikoto\ApiBundle\Form\StaticPageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class HomeController
 *
 * @package DeepMikoto\AdminBundle\Controller
 */
class HomeController extends Controller
{

    /**
     *  Main admin page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('DeepMikotoAdminBundle:Home:index.html.twig');
    }

    /**
     * Home sidebar primary block form
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function primaryBlockAction(Request $request)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $sidebarPrimaryBlock = $em->getRepository( 'DeepMikotoApiBundle:SidebarPrimaryBlock' )->findOneBy(
            [ 'type' => 'home']
        );
        $sidebarPrimaryBlock == null ? $sidebarPrimaryBlock = new SidebarPrimaryBlock() : null ;
        $form = $this->createForm( new SidebarPrimaryBlockType(), $sidebarPrimaryBlock );
        if( $request-> isMethod( 'POST' ) ){
            $form->handleRequest( $request );
            if( $form->isValid() ){
                $sidebarPrimaryBlock->setType( 'home' );
                $em->persist( $sidebarPrimaryBlock );
                $em->flush( $sidebarPrimaryBlock );
                $this->addFlash( 'success', '<strong>Awesome!</strong> You updated the homepage primary block!' );

                return $this->redirectToRoute( 'deepmikoto_admin_primary_block' );
            }
        }
        if( $sidebarPrimaryBlock->getPicture() != null ){
            $picturePath = $this->container->get('liip_imagine.cache.manager')->getBrowserPath( 'images/api/' . $sidebarPrimaryBlock->getPicture(), 'sidebar_primary_block');
        } else {
            $picturePath = null;
        }

        return $this->render('DeepMikotoAdminBundle:Parts:primary_block_form.html.twig', [ 'form' => $form->createView(), 'picture' => $picturePath, 'type' => 'home' ]);
    }

    public function helpPageAction()
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $helpPage = $em->getRepository('DeepMikotoApiBundle:StaticPage')->findOneBy([
            'name' => 'help-page'
        ]);
        if($helpPage == null){
            $helpPage = new StaticPage();
            $helpPage->setName('help-page')->setContent('<h1>Help page</h1>');
            $em->persist( $helpPage );
            $em->flush();
        }

        return $this->render('@DeepMikotoAdmin/Home/help_page.html.twig',[ 'help_page' => $helpPage ] );
    }

    public function helpPageEditAction(Request $request)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $helpPage = $em->getRepository('DeepMikotoApiBundle:StaticPage')->findOneBy([
            'name' => 'help-page'
        ]);
        $form = $this->createForm( new StaticPageType(), $helpPage );
        if( $request->isMethod('POST') ){
            $form->handleRequest( $request );
            if( $form->isValid() ){
                $em->persist( $helpPage );
                $em->flush();
                $this->addFlash( 'success', '<strong>Awesome!</strong> You updated the help page' );
                return $this->redirectToRoute('deepmikoto_admin_help_page');
            }
        }

        return $this->render('@DeepMikotoAdmin/Home/help_page_update.html.twig',[ 'form' => $form->createView() ] );
    }

    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function administrationAction()
    {
        return $this->render( 'DeepMikotoAdminBundle:Home:administration.html.twig' );
    }
}
