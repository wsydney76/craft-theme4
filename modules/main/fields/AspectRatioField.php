<?php

namespace modules\main\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Cp;
use function opcache_compile_file;

class AspectRatioField extends Field
{

    public string $defaultAspectRatio = 'auto';

    /**
     * @inheritDoc
     */
    public static function displayName(): string
    {
        return 'Aspect Ratio';
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


    public function getSettingsHtml(): ?string
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
    public function getInputHtml(mixed $value, ?\craft\base\ElementInterface $element = null): string
    {

        return Cp::selectHtml([
            'name' => $this->handle,
            'value' => $value,
            'options' =>  $this->options
        ]);
    }

    public function normalizeValue(mixed $value, ?\craft\base\ElementInterface $element = null): mixed
    {

        // If this is a new entry, look for any default options
        if ($value === null && $this->isFresh($element) && $this->defaultAspectRatio) {
            $value = $this->defaultAspectRatio;
        }

        return $value;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function getOptions(): array
    {
        return [
            ['label' => Craft::t('site','Theme Default'), 'value' => 'default'],
            ['label' => Craft::t('site','Auto'), 'value' => 'auto'],
            ['label' => '1:1', 'value' => '1:1'],
            ['label' => '4:3', 'value' => '4:3'],
            ['label' => '16:9', 'value' => '16:9'],
            ['label' => '21:9', 'value' => '21:9'],
            ['label' => '3:4', 'value' => '3:4'],
            ['label' => '1:2', 'value' => '1:2'],
            ['label' => Craft::t('site','Full Width'), 'value' => 'fullwidth'],
        ];
    }

}

