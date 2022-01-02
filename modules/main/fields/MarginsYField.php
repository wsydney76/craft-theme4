<?php

namespace modules\main\fields;

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
            'options' => [
                ['label' => 'Top and Bottom', 'value' => 'my-block'],
                ['label' => 'None', 'value' => 'my-0'],
                ['label' => 'Top only', 'value' => 'mt-block'],
                ['label' => 'Bottom only', 'value' => 'mb-block'],
            ]
        ]);
    }


}

