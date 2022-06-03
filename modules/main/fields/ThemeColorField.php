<?php

namespace modules\main\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Cp;

class ThemeColorField extends Field
{

    public $defaultColor;

    /**
     * @inheritDoc
     */
    public static function displayName(): string
    {
        return 'Theme Color';
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

    /** @inheritdoc */
    public function getSettingsHtml(): ?string
    {
        return Cp::selectFieldHtml([
            'label' => 'Default Color',
            'id' => 'default-color',
            'name' => 'defaultColor',
            'options' => $this->getOptions(),
            'value' => $this->defaultColor,
            'errors' => $this->getErrors('defaultColor'),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getInputHtml(mixed $value, ?\craft\base\ElementInterface $element = null): string
    {

        return Cp::selectHtml([
            'name' => $this->handle,
            'value' => $value,
            'options' => $this->getOptions()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue(mixed $value, ?\craft\base\ElementInterface $element = null): mixed
    {

        // If this is a new entry, look for any default options
        if ($value === null && $this->isFresh($element) && $this->defaultColor) {
            $value = $this->defaultColor;
        }

        return $value;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function getOptions(): array
    {
        return [
            ['label' => Craft::t('site', 'Default'), 'value' => 'default'],
            ['label' => Craft::t('site', 'Primary'), 'value' => 'primary'],
            ['label' => Craft::t('site', 'Secondary'), 'value' => 'secondary'],
            ['label' => Craft::t('site', 'Background'), 'value' => 'background'],
            ['label' => Craft::t('site', 'Foreground'), 'value' => 'foreground'],
            ['label' => Craft::t('site', 'Frame Background'), 'value' => 'frame-background'],
            ['label' => Craft::t('site', 'Black'), 'value' => 'black'],
            ['label' => Craft::t('site', 'White'), 'value' => 'white'],
            ['label' => Craft::t('site', 'Light'), 'value' => 'light'],
            ['label' => Craft::t('site', 'Color Three'), 'value' => 'three'],
            ['label' => Craft::t('site', 'Color Four'), 'value' => 'four'],
            ['label' => Craft::t('site', 'Title Background'), 'value' => 'title-bg'],
            ['label' => Craft::t('site', 'Title Text'), 'value' => 'title-text'],
            ['label' => Craft::t('site', 'Footer Background'), 'value' => 'footer-bg'],
            ['label' => Craft::t('site', 'Footer Text'), 'value' => 'footer-text'],
            ['label' => Craft::t('site', 'Footer Border'), 'value' => 'footer-border'],
            ['label' => Craft::t('site', 'Border'), 'value' => 'border'],
            ['label' => Craft::t('site', 'Muted'), 'value' => 'muted'],
            ['label' => Craft::t('site', 'Teaser'), 'value' => 'teaser'],
        ];
}
}

