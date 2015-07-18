<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 6/6/2015
 * Time: 14:07
 */

namespace DeepMikoto\ApiBundle\Controller;


use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Handles api routes
 *
 * Class ApiController
 * @package DeepMikoto\ApiBundle\Controller
 */
class ApiController extends FOSRestController
{
    /**
     * Api homepage
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $response = new Response(
            $this->render('DeepMikotoApiBundle:Api:index.html.twig')->getContent(),
            200
        );
        $response->setExpires(new \DateTime('+3 months'));
        $response->setPublic();

        return $response;
    }

    /**
     * Api templates
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function templatesAction()
    {
        $response = new Response(
            $this->get('deepmikoto.api.templating')->compileTemplates(),
            200
        );
        $response->setExpires(new \DateTime('+3 months'));
        $response->setPublic();
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Retrieve user info
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userInfoAction()
    {
        $response = new Response(
            $this->get('deepmikoto.api')->getUserInfo(),
            200
        );
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}