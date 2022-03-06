<?php

namespace modules\genericfields;

use Craft;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterTemplateRootsEvent;
use craft\services\Fields;
use craft\web\View;
use modules\genericfields\fields\ReverseRelationField;
use yii\base\Event;
use yii\base\Module;

class GenericFieldsModule extends Module
{
    public function init(): void
    {
        Craft::setAlias('@modules/genericfields', $this->getBasePath());

        // Register Templates directory
        Event::on(
            View::class,
            View::EVENT_REGISTER_CP_TEMPLATE_ROOTS, function(RegisterTemplateRootsEvent $e): void {
            $e->roots['genericfields'] = $this->getBasePath() . DIRECTORY_SEPARATOR . 'templates';
        });

        // Register custom field types
        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES, function(RegisterComponentTypesEvent $event): void {
            $event->types[] = ReverseRelationField::class;
        });

        parent::init();
    }
}
