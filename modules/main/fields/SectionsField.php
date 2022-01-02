<?php

namespace modules\main\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Cp;
use craft\web\twig\variables\CraftVariable;
use function array_map;

class SectionsField extends Field
{

    /**
     * @inheritDoc
     */
    public static function displayName(): string
    {
        return 'Sections';
    }

    /**
     * @return string|null
     */
    public function getHandle(): ?string
    {
        return $this->handle;
    }

    /**
     * @inheritDoc
     */
    public static function supportedTranslationMethods(): array
    {
        return [
            self::TRANSLATION_METHOD_NONE,
        ];
    }


    /**
     * @inheritDoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {

        return Cp::selectHtml([
            'name' => $this->handle,
            'value' => $value,
            'options' =>  array_map(
                function($section) {
                    return ['label' => $section->name, 'value' => $section->handle];
                }, Craft::$app->sections->getAllSections()
            )
        ]);
    }


}

