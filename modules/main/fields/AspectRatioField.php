<?php

namespace modules\main\fields;

use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Cp;
use function opcache_compile_file;

class AspectRatioField extends Field
{

    public $defaultAspectRatio = 'auto';

    protected $options = [
        ['label' => 'Theme Default', 'value' => 'default'],
        ['label' => 'Auto', 'value' => 'auto'],
        ['label' => '1:1', 'value' => '1_1'],
        ['label' => '4:3', 'value' => '4_3'],
        ['label' => '16:9', 'value' => '16_9'],
        ['label' => '21:9', 'value' => '21_9'],
        ['label' => '3:4', 'value' => '3_4'],
        ['label' => '1:2', 'value' => '1_2'],
        ['label' => 'Full Width', 'value' => 'fullwidth'],
    ];

    /**
     * @inheritDoc
     */
    public static function displayName(): string
    {
        return 'Aspect Ratio';
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


    public function getSettingsHtml()
    {
        return Cp::selectFieldHtml([
                'label' => 'Default Aspect Ratio',
                'id' => 'default-aspect-ratio',
                'name' => 'defaultAspectRatio',
                'options' => $this->options,
                'value' => $this->defaultAspectRatio,
                'errors' => $this->getErrors('defaultAspectRatio'),
            ]) ;
    }

    /**
     * @inheritDoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {

        return Cp::selectHtml([
            'name' => $this->handle,
            'value' => $value,
            'options' =>  $this->options
        ]);
    }

    public function normalizeValue($value, ElementInterface $element = null)
    {

        // If this is a new entry, look for any default options
        if ($value === null && $this->isFresh($element) && $this->defaultAspectRatio) {
            $value = $this->defaultAspectRatio;
        }

        return $value;
    }

}

