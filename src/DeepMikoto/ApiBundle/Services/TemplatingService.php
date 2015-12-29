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
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $data = [
            'appHeader' => $twigEngine->render( 'DeepMikotoApiBundle:templates:header/_header.html.twig' ),
            'sidebar' => $twigEngine->render( 'DeepMikotoApiBundle:templates:sidebar/_sidebar.html.twig' ),
            'codingTimelineCollection' => $twigEngine->render( 'DeepMikotoApiBundle:templates:coding/_timeline_collection.html.twig' ),
            'codingTimelineItem' => $twigEngine->render( 'DeepMikotoApiBundle:templates:coding/_timeline_item.html.twig' ),
            'codingPost' => $twigEngine->render( 'DeepMikotoApiBundle:templates:coding/_coding_post.html.twig' ),
            'gamingTimelineCollection' => $twigEngine->render( 'DeepMikotoApiBundle:templates:gaming/_timeline_collection.html.twig' ),
            'gamingTimelineItem' => $twigEngine->render( 'DeepMikotoApiBundle:templates:gaming/_timeline_item.html.twig' ),
            'gamingPost' => $twigEngine->render( 'DeepMikotoApiBundle:templates:gaming/_gaming_post.html.twig' ),
            'photographyTimelineCollection' => $twigEngine->render( 'DeepMikotoApiBundle:templates:photography/_timeline_collection.html.twig' ),
            'photographyTimelineItem' => $twigEngine->render( 'DeepMikotoApiBundle:templates:photography/_timeline_item.html.twig' ),
            'photographyPost' => $twigEngine->render( 'DeepMikotoApiBundle:templates:photography/_photography_post.html.twig' ),
            'footNote' => $twigEngine->render( 'DeepMikotoApiBundle:templates:footnote/_default.html.twig' )
        ];

        return $this->serializer->serialize( $data, 'json' );
    }
} 