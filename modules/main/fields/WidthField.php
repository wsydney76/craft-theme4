<?php

namespace modules\main\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Cp;
use function array_merge_recursive;

class WidthField extends Field
{

    /**
     * @var string|null The default width
     */
    public $defaultWidth;
    public $addDefaultOptions = false;
    public $addMobileOptions = false;

    /**
     * @inheritDoc
     */
    public static function displayName(): string
    {
        return 'Width';
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
                'label' => 'Default Width',
                'id' => 'default-width',
                'name' => 'defaultWidth',
                'options' => $this->getOptions(true),
                'value' => $this->defaultWidth,
                'errors' => $this->getErrors('defaultWidth'),
            ]) .
            Cp::lightswitchFieldHtml([
                'label' => 'Add mobile options',
                'id' => 'add-mobile-options',
                'name' => 'addMobileOptions',
                'on' => $this->addMobileOptions
            ]) .
            Cp::lightswitchFieldHtml([
                'label' => 'Add default options',
                'id' => 'add-default-options',
                'name' => 'addDefaultOptions',
                'on' => $this->addDefaultOptions
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
            'options' => $this->getOptions()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {

        // If this is a new entry, look for any default options
        if ($value === null && $this->isFresh($element) && $this->defaultWidth) {
            $value = $this->defaultWidth;
        }

        return $value;
    }

    protected function getOptions($isSettings = false)
    {
        $options = $this->getMainOptions();
        if ($this->addDefaultOptions || $isSettings) {
            $options = array_merge($this->getDefaultOptions(), $options);
        }
        if ($this->addMobileOptions || $isSettings) {
            $options = array_merge($options, $this->getMobileOptions());
        }
        return $options;
    }

    protected function getMainOptions()
    {
        return [
            ['label' => Craft::t('site', 'Small (640px)'), 'value' => 'sm'],
            ['label' => Craft::t('site', 'Medium (768px)'), 'value' => 'md'],
            ['label' => Craft::t('site', 'Medium Large (896px)'), 'value' => 'ml'],
            ['label' => Craft::t('site', 'Large (1024px)'), 'value' => 'lg'],
            ['label' => Craft::t('site', 'Extra Large (1280px)'), 'value' => 'xl'],
            ['label' => Craft::t('site', 'Huge (1536px)'), 'value' => '2xl'],
            ['label' => Craft::t('site', 'Full'), 'value' => 'full'],
        ];
    }

    protected function getDefaultOptions()
    {
        return [
            ['label' => Craft::t('site','Default'), 'value' => 'default']
        ];
    }

    protected function getMobileOptions()
    {
        return [
            ['label' => Craft::t('site', 'Always show mobile menu'), 'value' => 'always'],
            ['label' => Craft::t('site', 'Never show mobile menu'), 'value' => 'never'],
        ];
    }
}

