<?php

namespace modules\main\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\fields\Entries;
use craft\helpers\ArrayHelper;
use craft\helpers\Cp;
use craft\models\EntryType;
use craft\models\FieldLayout;
use craft\models\Section;

/**
 * TODOS:
 * - Allow multiple sections/types
 * - Use (dynamic) select fields instead of plaintext for section/type/field
 * - hide on fresh entries
 * - open existing related entries in slideout, remove relationship like in relation fields
 * - refresh entries list via ajax after a new entry was created
 *
 * @property-read string $settingsHtml
 */
class ReverseRelationField extends Field
{

    public string $caption = 'Create new';
    public string $field = '';
    public string $orderBy = 'title';
    public string $section = '';
    public string $type = '';

    private FieldLayout|null $fieldLayout = null;

    /**
     * @inheritDoc
     */
    public static function displayName(): string
    {
        return 'Reverse Relations';
    }

    /**
     * @return string|null
     */
    public function getHandle(): ?string
    {
        return $this->handle;
    }

    /**
     * @inheritdoc
     */
    public static function hasContentColumn(): bool
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public static function supportedTranslationMethods(): array
    {
        // Don't ever automatically propagate values to other sites.
        return [
            self::TRANSLATION_METHOD_NONE,
        ];
    }

    public function rules(): array
    {
        $rules = parent::rules();
        $rules[] = [['section', 'caption', 'field'], 'required'];
        $rules[] = ['section', 'checkSection'];
        $rules[] = ['field', 'checkField'];

        return $rules;
    }

    public function checkField(): void
    {
        $field = Craft::$app->fields->getFieldByHandle($this->field);
        if (!$field) {
            $this->addError('field', 'Invalid field handle');
            return;
        }
        if (!$field instanceof Entries) {
            $this->addError('field', 'Field is not an entries field');
        }

        if (!$this->fieldLayout) {
            return;
        }

        $fields = $this->fieldLayout->getFields();
        $found = ArrayHelper::firstWhere($fields, 'handle', $this->field);
        if (!$found) {
            $this->addError('field', 'Field is not part of the field layout');
        }
    }

    public function checkSection(): void
    {
        $section = Craft::$app->sections->getSectionByHandle($this->section);
        if (!$section) {
            $this->addError('section', 'Invalid section handle');
            return;
        }

        if ($section->type == Section::TYPE_SINGLE) {
            $this->addError('section', 'Section cannot be a single');
            return;
        }

        $types = $section->getEntryTypes();
        /** @var EntryType $type */

        if ($this->type) {
            $type = ArrayHelper::firstWhere($types, 'handle', $this->type);
            if (!$type) {
                $this->addError('type', 'Invalid type handle');
                return;
            }
        } else {
            $type = $types[0];
        }

        $this->fieldLayout = $type->fieldLayout;
    }

    /**
     * @inheritDoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {

        return Craft::$app->view->renderTemplate('main/reverse-relation.twig', [
            'element' => $element,
            'section' => $this->section,
            'type' => $this->type,
            'field' => $this->field,
            'caption' => $this->caption,
            'orderBy' => $this->orderBy,
        ]);
    }

    /** @inheritdoc */
    public function getSettingsHtml(): ?string
    {
        return Cp::textFieldHtml([
                'label' => 'Section handle',
                'id' => 'section',
                'name' => 'section',
                'value' => $this->section,
                'required' => true,
                'size' => 30,
                'errors' => $this->getErrors('section'),
            ]) .
            Cp::textFieldHtml([
                'label' => 'Type handle',
                'id' => 'type',
                'name' => 'type',
                'value' => $this->type,
                'size' => 30,
                'instructions' => 'Leave blank to use the first type of the section',
                'errors' => $this->getErrors('type'),
            ]) .
            Cp::textFieldHtml([
                'label' => 'Field handle',
                'id' => 'field',
                'name' => 'field',
                'value' => $this->field,
                'required' => true,
                'size' => 30,
                'errors' => $this->getErrors('field'),
            ]) .
            Cp::textFieldHtml([
                'label' => 'Order By',
                'id' => 'orderBy',
                'name' => 'orderBy',
                'value' => $this->orderBy,
                'instructions' => 'Leave blank to use the default order',
                'size' => 30,
                'errors' => $this->getErrors('orderBy'),
            ]) .
            Cp::textFieldHtml([
                'label' => 'Caption',
                'id' => 'caption',
                'name' => 'caption',
                'value' => $this->caption,
                'required' => true,
                'size' => 30,
                'errors' => $this->getErrors('caption'),
            ]);
    }
}
