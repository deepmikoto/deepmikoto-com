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
            $this->render('DeepMikotoApiBundle:Api:index.html.twig')->getContent(),
            200
        );
        /** 90 days */
        $response->setSharedMaxAge( 7776000 );
        $response->setMaxAge( 60 );

        return $response;
    }

} 