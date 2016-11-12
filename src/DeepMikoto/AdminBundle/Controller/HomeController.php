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
        /** @var \Minishlink\WebPush\WebPush */
        $webPush = $this->get('minishlink_web_push');
        var_dump($webPush->sendNotification(
            'https://fcm.googleapis.com/fcm/send/eqEHGaKmogo:APA91bGsy2Ox-0sa3aFzEcl5rX5-UcTHQtdr_XSzSYJ88uN0LWDSBtpDs0OVE0NFGeeXjAjwT1wcCo7Kp1zbDwHq7b6lCJ3I5uq8zVwg927gIc0d3874e_P8MzGA7nQpU7V7oIf6iopW',
            json_encode([
                'body' => 'Yay!',
                'icon' => '/icon.png',
                'badge' => '/badge.png'
            ]),
            'BNQd6rR0CRMagYgLiUQ-OEcv7kb7aTJqZODXa1Ff1njFFBrBTPV5YYKncyoL6GuMHKQHJI-20sqddC9jN4Xbih0=',
            '3voJrzTr-xWrudRDHntl8w==',
            true
        ));

        return $this->render('DeepMikotoAdminBundle:Home:index.html.twig');
    }

    public function helpPageAction()
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $helpPage = $em->getRepository('DeepMikotoApiBundle:StaticPage')->findOneBy([
            'name' => 'help'
        ]);
        if($helpPage == null){
            $helpPage = new StaticPage();
            $helpPage->setName('help')->setContent('<h1>Help page</h1>');
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
            'name' => 'help'
        ]);
        $form = $this->createForm( StaticPageType::class, $helpPage );
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
