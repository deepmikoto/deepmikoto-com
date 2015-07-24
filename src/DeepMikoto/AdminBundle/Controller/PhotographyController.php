<?php

namespace DeepMikoto\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

}
