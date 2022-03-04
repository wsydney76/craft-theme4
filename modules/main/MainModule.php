<?php

namespace modules\main;

use Craft;
use craft\elements\Asset;
use craft\elements\Entry;
use craft\events\DefineBehaviorsEvent;
use craft\events\DefineRulesEvent;
use craft\events\ModelEvent;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterTemplateRootsEvent;
use craft\services\Fields;
use craft\web\View;
use modules\main\behaviors\EntryBehavior;
use modules\main\fields\AspectRatioField;
use modules\main\fields\IncludeField;
use modules\main\fields\MarginsYField;
use modules\main\fields\OrderByField;
use modules\main\fields\SectionsField;
use modules\main\fields\ThemeColorField;
use modules\main\fields\WidthField;
use modules\main\twigextensions\TwigExtension;
use modules\resources\cp\CpAssets;
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
        });

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
        });

        // Register Twig extension for theme variable
        Craft::$app->view->registerTwigExtension(new TwigExtension());

        // Register CP assets
        if (Craft::$app->request->isCpRequest) {
            Event::on(
                View::class,
                View::EVENT_BEFORE_RENDER_TEMPLATE, function() {
                Craft::$app->view->registerAssetBundle(CpAssets::class);
            }
            );
        }


        // Validate entries on all sites (fixes open Craft bug)
        Event::on(
            Entry::class,
            Entry::EVENT_BEFORE_SAVE, function($event) {

            if (Craft::$app->sites->getTotalSites() == 1) {
                return;
            }

            /** @var Entry $entry */
            $entry = $event->sender;

            // TODO: Check conditionals

            if ($entry->resaving || $entry->propagating || $entry->getScenario() != Entry::STATUS_LIVE) {
                return;
            }

            $entry->validate();

            if ($entry->hasErrors()) {
                return;
            }

            foreach ($entry->getLocalized()->all() as $localizedEntry) {
                $localizedEntry->scenario = Entry::SCENARIO_LIVE;

                if (!$localizedEntry->validate()) {
                    $entry->addError(
                        $entry->getType()->hasTitleField ? 'title' : 'slug',
                        Craft::t('site', 'Error validating entry in') .
                        ' "' . $localizedEntry->site->name . '". ' .
                        implode(' ', $localizedEntry->getErrorSummary(false)));
                    $event->isValid = false;
                }
            }
        });

        // Rename images with extension 'jfif' to 'jpg'
        // see config/general.php for an explanation
        Event::on(
            Asset::class,
            Asset::EVENT_AFTER_SAVE, function(ModelEvent $event) {
            /** @var Asset $asset */
            $asset = $event->sender;

            if ($asset->kind != 'image') {
                return;
            }

            $pathInfo = pathinfo($asset->getFilename());
            if ($pathInfo['extension'] != 'jfif') {
                return;
            }

            $newFilename = $pathInfo['filename'] . '.jpg';
            Craft::$app->assets->moveAsset($asset, $asset->getFolder(), $newFilename);
        });
    }

}
