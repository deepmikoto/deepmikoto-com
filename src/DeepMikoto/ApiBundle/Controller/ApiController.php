<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 6/6/2015
 * Time: 14:07
 */

namespace DeepMikoto\ApiBundle\Controller;


use FOS\RestBundle\Controller\FOSRestController;

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
        $data = [
            'user' => $this->getUser()
        ];
        $view = $this->view($data, 200)
            ->setTemplate('DeepMikotoApiBundle:Api:index.html.twig')
            ->setTemplateVar('data')
        ;

        return $this->handleView($view);
    }
} 