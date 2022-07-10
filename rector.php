<?php

declare(strict_types = 1);

use Rector\CodingStyle\Rector\ClassConst\RemoveFinalFromConstRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\Core\Configuration\Option;
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function(ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/src'
    ]);

    $parameters->set(Option::SKIP, [
        StringClassNameToClassConstantRector::class,
        EncapsedStringsToSprintfRector::class,
        RemoveFinalFromConstRector::class // requires PHP 8.1
    ]);

    // Define what rule sets will be applied

    $containerConfigurator->import(SetList::CODE_QUALITY);

    $containerConfigurator->import(SetList::CODING_STYLE);

    $containerConfigurator->import(SetList::TYPE_DECLARATION);

    $containerConfigurator->import(LevelSetList::UP_TO_PHP_80);

    // get services (needed for register a single rule)
    // $services = $containerConfigurator->services();

    // register a single rule
    // $services->set(TypedPropertyRector::class);
};
