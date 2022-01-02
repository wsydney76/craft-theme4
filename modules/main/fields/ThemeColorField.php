<?php

namespace modules\main\fields;

use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Cp;

class ThemeColorField extends Field
{

    public $defaultColor;

    protected $options = [
        ['label' => 'Default', 'value' => 'default'],
        ['label' => 'Primary', 'value' => 'primary'],
        ['label' => 'Secondary', 'value' => 'secondary'],
        ['label' => 'Light', 'value' => 'light'],
        ['label' => 'Background', 'value' => 'background'],
        ['label' => 'Foreground', 'value' => 'foreground'],
        ['label' => 'Frame-Background', 'value' => 'frame-background'],
        ['label' => 'Black', 'value' => 'black'],
        ['label' => 'White', 'value' => 'white'],
        ['label' => 'Three', 'value' => 'three'],
        ['label' => 'Four', 'value' => 'four'],
    ];

    /**
     * @inheritDoc
     */
    public static function displayName(): string
    {
        return 'Theme Color';
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


    /** @inheritdoc */
    public function getSettingsHtml()
    {
        return Cp::selectFieldHtml([
            'label' => 'Default Color',
            'id' => 'default-color',
            'name' => 'defaultColor',
            'options' => $this->options,
            'value' => $this->defaultColor,
            'errors' => $this->getErrors('defaultColor'),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {

        return Cp::selectHtml([
            'name' => $this->handle,
            'value' => $value,
            'options' => $this->options
        ]);
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {

        // If this is a new entry, look for any default options
        if ($value === null && $this->isFresh($element) && $this->defaultColor) {
            $value = $this->defaultColor;
        }

        return $value;
    }

}

