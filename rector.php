<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;

return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/src'
    ]);

    $parameters->set(Option::SKIP, [
        StringClassNameToClassConstantRector::class
    ]);

    // Define what rule sets will be applied
    // $containerConfigurator->import(LevelSetList::UP_TO_PHP_80);

    $containerConfigurator->import(SetList::CODE_QUALITY);

    // get services (needed for register a single rule)
    // $services = $containerConfigurator->services();

    // register a single rule
    // $services->set(TypedPropertyRector::class);
};
