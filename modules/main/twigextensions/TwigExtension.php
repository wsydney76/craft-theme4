<?php

namespace modules\main\twigextensions;

use Craft;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;

class TwigExtension extends AbstractExtension implements GlobalsInterface
{
    public function getGlobals(): array
    {
        return [
            'theme' => Craft::$app->config->getConfigFromFile('theme')
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('one', [$this, 'oneFilter']),
            new TwigFilter('all', [$this, 'allFilter']),
        ];
    }

    public function oneFilter($stuff)
    {
        if (is_null($stuff)) {
            return null;
        }
        if (is_array($stuff)) {
            return (count($stuff) ? $stuff[0] : null);
        }
        return $stuff->one();
    }

    public function allFilter($stuff)
    {
        if (is_null($stuff))
        {
            return [];
        }
        if (is_array($stuff))
        {
            return ($stuff);
        }
        return $stuff->all();
    }
}
