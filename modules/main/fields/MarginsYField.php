<?php

namespace modules\main\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Cp;

class MarginsYField extends Field
{

    /**
     * @inheritDoc
     */
    public static function displayName(): string
    {
        return 'Margins Y';
    }

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
    public function getInputHtml(mixed $value, ?\craft\base\ElementInterface $element = null): string
    {

        return Cp::selectHtml([
            'name' => $this->handle,
            'value' => $value,
            'options' => [
                ['label' => Craft::t('site', 'Top and Bottom'), 'value' => 'my-block'],
                ['label' => Craft::t('site', 'None'), 'value' => 'my-0'],
                ['label' => Craft::t('site', 'Top only'), 'value' => 'mt-block'],
                ['label' => Craft::t('site', 'Bottom only'), 'value' => 'mb-block'],
            ]
        ]);
    }


}

