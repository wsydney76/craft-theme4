<?php

namespace modules\main\fields;

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

    protected $options = [
        ['label' => 'Small (640px)', 'value' => 'sm'],
        ['label' => 'Medium (768px)', 'value' => 'md'],
        ['label' => 'Medium Large (896px)', 'value' => 'ml'],
        ['label' => 'Large (1024px)', 'value' => 'lg'],
        ['label' => 'Extra Large (1280px)', 'value' => 'xl'],
        ['label' => 'Huge (1536px)', 'value' => '2xl'],
        ['label' => 'Full', 'value' => 'full'],
    ];

    protected $mobileOptions = [
        ['label' => 'Always show mobile menu', 'value' => 'always'],
        ['label' => 'Never show mobile menu', 'value' => 'never'],
    ];

    protected $defaultOptions = [
      ['label' => 'Default', 'value' => 'default']
    ];

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
        $options = $this->options;
        if ($this->addDefaultOptions || $isSettings) {
            $options = array_merge($this->defaultOptions, $options);
        }
        if ($this->addMobileOptions || $isSettings) {
            $options = array_merge($options, $this->mobileOptions);
        }
        return $options;
    }

}

