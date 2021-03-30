<?php

namespace App\Casts;

use App\Nova\Flexible\Layouts\CallToActionLayout;
use App\Nova\Flexible\Layouts\CardLayout;
use App\Nova\Flexible\Layouts\CardsContainerLayout;
use App\Nova\Flexible\Layouts\CodeSnippetLayout;
use Whitecube\NovaFlexibleContent\Value\FlexibleCast;

class WebpageFlexibleCast extends FlexibleCast {

    const LAYOUT_CARD = 'content_element_card';
    const LAYOUT_CTA = 'content_element_cta';
    const LAYOUT_CARDS_CONTAINER = 'content_element_cards_container';
    const LAYOUT_SNIPPET = 'content_element_snippet';

    protected $layouts = [
        self::LAYOUT_CARD    => CardLayout::class,
        self::LAYOUT_CTA     => CallToActionLayout::class,
        self::LAYOUT_SNIPPET => CodeSnippetLayout::class,
        self::LAYOUT_CARDS_CONTAINER => CardsContainerLayout::class
    ];


    public function getLayoutsForTesting() {
        return $this->layouts;
    }
}
