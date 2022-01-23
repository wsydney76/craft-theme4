<?php

namespace modules\main\twigextensions;

use Craft;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;

class TwigExtension extends AbstractExtension implements GlobalsInterface
{
    /**
     * @return array
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
    public function getFilters()
    {
        return [
            new TwigFilter('one', [$this, 'oneFilter']),
            new TwigFilter('all', [$this, 'allFilter']),
            new TwigFilter('quote', [$this, 'quoteFilter']),
        ];
    }

    /**
     * @param $stuff
     * @return mixed|null
     */
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

    /**
     * @param $stuff
     * @return array
     */
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

    /**
     * @param string $text
     * @return string
     */
    public function quoteFilter(string $text): string
    {
        return Craft::t('site', '“') . $text . Craft::t('site', '”') ;
    }
}
