<?php

namespace modules\main\twigextensions;

use Craft;
use craft\helpers\Template;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;
use yii\helpers\Markdown;
use function str_replace;

class TwigExtension extends AbstractExtension implements GlobalsInterface
{
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
            new TwigFilter('one', function ($stuff) {
                return $this->oneFilter($stuff);
            }),
            new TwigFilter('all', function ($stuff) : array {
                return $this->allFilter($stuff);
            }),
            new TwigFilter('quote', function (string $text) : string {
                return $this->quoteFilter($text);
            })
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

    public function quoteFilter(string $text): string
    {
        return Craft::t('site', '“') . $text . Craft::t('site', '”') ;
    }

}
