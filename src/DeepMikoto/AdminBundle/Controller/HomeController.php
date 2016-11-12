<?php

namespace DeepMikoto\AdminBundle\Controller;

use DeepMikoto\ApiBundle\Entity\SidebarPrimaryBlock;
use DeepMikoto\ApiBundle\Entity\StaticPage;
use DeepMikoto\ApiBundle\Form\SidebarPrimaryBlockType;
use DeepMikoto\ApiBundle\Form\StaticPageType;
use Doctrine\ORM\EntityManager;
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
     *  push messaging page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pushNotificationAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $subscriptions = $em->getRepository('DeepMikotoApiBundle:PushNotificationSubscription')->findBy( [], [ 'createdAt' => 'DESC' ] );
        if ( $request->isMethod('POST') && !empty( $subscriptions )) {
            $title = $request->get('title');
            $message = $request->get('message');
            $url = $request->get('url');
            /** @var \Minishlink\WebPush\WebPush */
            $webPush = $this->get('minishlink_web_push');
            foreach ($subscriptions as $subscription) {
                $webPush->sendNotification(
                    $subscription->getEndpoint(),
                    json_encode([
                        'title' => $title,
                        'body' => $message,
                        'data' => [
                            'targetURL' => $url
                        ],
                        'icon' => '/bundles/deepmikotoapi/images/deepmikoto_logo_300_300.png',
                        'badge' => '/bundles/deepmikotoapi/images/deepmikoto_logo_300_300.png'
                    ]),
                    $subscription->getUserPublicKey(),
                    $subscription->getUserAuthToken()
                );
            }
            $sendStatus = $webPush->flush();
            if ( $sendStatus == true ) {
                $this->addFlash('success', 'Successfully sent ' . count( $subscriptions ) . ' notifications');
            } else {
                $this->addFlash( 'error', $sendStatus );
            }

            return $this->redirectToRoute('deepmikoto_admin_push_notifications');
        }

        return $this->render('DeepMikotoAdminBundle:Home:push_notifications.html.twig',[
            'subscriptions' => $subscriptions
        ]);
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
