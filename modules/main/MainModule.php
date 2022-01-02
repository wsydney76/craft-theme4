<?php

namespace modules\main;

use Craft;
use craft\elements\Entry;
use craft\events\DefineBehaviorsEvent;
use craft\events\DefineRulesEvent;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Fields;
use modules\main\behaviors\EntryBehavior;
use modules\main\fields\AspectRatioField;
use modules\main\fields\IncludeField;
use modules\main\fields\MarginsYField;
use modules\main\fields\OrderByField;
use modules\main\fields\SectionsField;
use modules\main\fields\ThemeColorField;
use modules\main\fields\WidthField;
use modules\main\twigextensions\TwigExtension;
use yii\base\Event;
use yii\base\Module;

/**
 * Class MainModule
 *
 * @package modules\main
 *

 */
class MainModule extends Module
{

    public static $app;

    public function init()
    {
        Craft::setAlias('@modules/main', $this->getBasePath());


        // Set the controllerNamespace based on whether this is a console or web request
        if (Craft::$app->getRequest()->getIsConsoleRequest()) {
            $this->controllerNamespace = 'modules\\main\\console\\controllers';
        } else {
            $this->controllerNamespace = 'modules\\main\\controllers';
        }


        // Register Behaviors
        Event::on(
            Entry::class,
            Entry::EVENT_DEFINE_BEHAVIORS, function(DefineBehaviorsEvent $event) {
            $event->behaviors[] = EntryBehavior::class;
        }
        );

        // Register Rules
        Event::on(
            Entry::class,
            Entry::EVENT_DEFINE_RULES, function(DefineRulesEvent $event) {
                $event->rules[] = ['title', 'string', 'max' => 50, 'on' => Entry::SCENARIO_LIVE];
        });

        // Register custom field types
        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES, function(RegisterComponentTypesEvent $event) {
            $event->types[] = IncludeField::class;
            $event->types[] = WidthField::class;
            $event->types[] = ThemeColorField::class;
            $event->types[] = MarginsYField::class;
            $event->types[] = SectionsField::class;
            $event->types[] = OrderByField::class;
            $event->types[] = AspectRatioField::class;
        }
        );

        // Register Twig extension for theme variable
        Craft::$app->view->registerTwigExtension(new TwigExtension());

    }


}
