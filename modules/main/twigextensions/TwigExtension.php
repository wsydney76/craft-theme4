<?php

namespace modules\main\twigextensions;


use Craft;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class TwigExtension extends AbstractExtension implements GlobalsInterface
{
    public function getGlobals(): array
    {
        return [
          'theme' => Craft::$app->config->getConfigFromFile('theme')
        ];
    }
}
