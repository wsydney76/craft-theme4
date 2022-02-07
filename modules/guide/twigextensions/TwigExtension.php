<?php

namespace modules\guide\twigextensions;

use craft\helpers\Template;
use Twig\Extension\AbstractExtension;
use Twig\Markup;
use Twig\TwigFilter;
use yii\helpers\Markdown;
use function str_replace;

class TwigExtension extends AbstractExtension
{

    /**
     * @return TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('guideText', [$this, 'guideTextFilter']),
        ];
    }

    /**
     * Don't format leading spaces as code
     *
     * @param string $text
     * @param $flavor
     * @return \Twig\Markup
     */
    public function guideTextFilter(string $text, $flavor = null): Markup
    {
        $text = str_replace(['    ', '  '], ['', ''], $text);

        return Template::raw(Markdown::process($text, $flavor));
    }
}