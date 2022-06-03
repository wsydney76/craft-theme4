<?php

namespace modules\main\twigextensions;

use Craft;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;

class TwigExtension extends AbstractExtension implements GlobalsInterface
{
    /**
     * @return array<string, mixed>
     */
    public function getGlobals(): array
    {
        return [
            'theme' => Craft::$app->config->getConfigFromFile('theme')
        ];
    }

    /**
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('quote', fn(string $text): string => $this->quoteFilter($text))
        ];
    }

    public function quoteFilter(string $text): string
    {
        return Craft::t('site', '“') . $text . Craft::t('site', '”');
    }

}
