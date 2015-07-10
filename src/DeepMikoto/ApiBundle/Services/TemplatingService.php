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
    public function __construct(TwigEngine $twigEngine, Serializer $serializer)
    {
        $this->twigEngine = $twigEngine;
        $this->serializer = $serializer;
    }

    public function compileTemplates()
    {
        $twigEngine = $this->twigEngine;
        $data = [
            'mainHeader' => $twigEngine->render('DeepMikotoApiBundle:Templates:_main_header.html.twig')
        ];

        return $this->serializer->serialize($data, 'json');
    }
} 