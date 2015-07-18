<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 7/10/2015
 * Time: 23:35
 */

namespace DeepMikoto\ApiBundle\Services;

use JMS\Serializer\Serializer;
use Symfony\Bundle\TwigBundle\TwigEngine;

/**
 * Class TemplatingService
 *
 * @package DeepMikoto\ApiBundle\Services
 */
class TemplatingService
{
    private $twigEngine;
    private $serializer;

    /**
     * initialize service components
     *
     * @param TwigEngine $twigEngine
     * @param Serializer $serializer
     */
    public function __construct( TwigEngine $twigEngine, Serializer $serializer )
    {
        $this->twigEngine = $twigEngine;
        $this->serializer = $serializer;
    }

    /**
     * render all app templates and serve them as json array
     *
     * @return mixed
     * @throws \Exception
     * @throws \Twig_Error
     */
    public function compileTemplates()
    {
        $twigEngine = $this->twigEngine;
        $data = [
            'appHeader'             => $twigEngine->render( 'DeepMikotoApiBundle:Templates:header/_header.html.twig' ),
            'sidebar'               => $twigEngine->render( 'DeepMikotoApiBundle:Templates:sidebar/_sidebar.html.twig' )
        ];

        return $this->serializer->serialize( $data, 'json' );
    }
} 