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
            'appHeader' => $twigEngine->render( '@DeepMikotoApi/templates/header/_header.html.twig' ),
            'sidebar' => $twigEngine->render( '@DeepMikotoApi/templates/sidebar/_sidebar.html.twig' ),
            'codingTimelineCollection' => $twigEngine->render( '@DeepMikotoApi/templates/coding/_timeline_collection.html.twig' ),
            'codingTimelineItem' => $twigEngine->render( '@DeepMikotoApi/templates/coding/_timeline_item.html.twig' ),
            'codingPost' => $twigEngine->render( '@DeepMikotoApi/templates/coding/_coding_post.html.twig' ),
            'gamingTimelineCollection' => $twigEngine->render( '@DeepMikotoApi/templates/gaming/_timeline_collection.html.twig' ),
            'gamingTimelineItem' => $twigEngine->render( '@DeepMikotoApi/templates/gaming/_timeline_item.html.twig' ),
            'gamingPost' => $twigEngine->render( '@DeepMikotoApi/templates/gaming/_gaming_post.html.twig' ),
            'photographyTimelineCollection' => $twigEngine->render( '@DeepMikotoApi/templates/photography/_timeline_collection.html.twig' ),
            'photographyTimelineItem' => $twigEngine->render( '@DeepMikotoApi/templates/photography/_timeline_item.html.twig' ),
            'photographyPost' => $twigEngine->render( '@DeepMikotoApi/templates/photography/_photography_post.html.twig' ),
            'footNote' => $twigEngine->render( '@DeepMikotoApi/templates/footnote/_default.html.twig' ),
            'landingPage' => $twigEngine->render( '@DeepMikotoApi/templates/landing/_landing_page.html.twig' ),
            'codingCategoryTimelineItem' => $twigEngine->render( '@DeepMikotoApi/templates/coding/_category_timeline_item.html.twig' ),
            'codingCategoryTimelineCollection' => $twigEngine->render( '@DeepMikotoApi/templates/coding/_categories_timeline_collection.html.twig' ),
            'searchSuggestionItemView' => $twigEngine->render('@DeepMikotoApi/templates/header/_search_suggestion_item_view.html.twig'),
            'searchSuggestions' => $twigEngine->render('@DeepMikotoApi/templates/header/_search_suggestions.html.twig')
        ];

        return $this->serializer->serialize( $data, 'json' );
    }
} 