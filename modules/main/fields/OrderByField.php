<?php

namespace modules\main\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Cp;

class OrderByField extends Field
{

    /**
     * @inheritDoc
     */
    public static function displayName(): string
    {
        return 'Order By';
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
            'options' =>  [
                ['label' => Craft::t('site', 'Default'), 'value' => ''],
                ['label' => Craft::t('site', 'PostDate desc'), 'value' => 'postDate desc'],
                ['label' => Craft::t('site', 'Title'), 'value' => 'title'],
            ]
        ]);
    }


}

