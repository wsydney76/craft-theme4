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
    public function getFilters(): array
    {
        return [
            new TwigFilter('guideText', fn(string $text, ?string $flavor = null): Markup => $this->guideTextFilter($text, $flavor)),
        ];
    }

    /**
     * Don't format leading spaces as code
     *
     * @param $flavor
     */
    public function guideTextFilter(string $text, ?string $flavor): Markup
    {
        $text = str_replace(['    ', '  '], ['', ''], $text);

        return Template::raw(Markdown::process($text, $flavor));
    }
}
