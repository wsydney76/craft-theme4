<?php

namespace modules\genericfields\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\errors\EntryTypeNotFoundException;
use craft\errors\InvalidFieldException;
use craft\errors\SectionNotFoundException;
use craft\fields\Entries;
use craft\helpers\ArrayHelper;
use craft\helpers\Cp;
use craft\models\Section;
use yii\base\InvalidConfigException;
use function explode;

/**
 * Handle relationships on the target side
 *
 * TODOS:
 * - Allow multiple sections/types
 * - hide on fresh entries
 * - open existing related entries in slideout, remove relationship like in relation fields
 * - refresh entries list via ajax after a new entry was created
 *
 * @property-read string $settingsHtml
 */
class ReverseRelationField extends Field
{
    /**
     * @var string section-uid/entrytype-uid/field-uid
     */
    public string $source = '';

    public string $caption = 'Create new';
    public string $orderBy = 'title';

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
    public function rules(): array
    {
        $rules = parent::rules();
        $rules[] = [['source', 'caption'], 'required'];

        return $rules;
    }

    /**
     * @inheritDoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {

        $uids = explode('/', $this->source);
        if (count($uids) != 3) {
            throw new InvalidConfigException('Source config is not in the format sectionUid/typeUid/fieldUid');
        }

        $section = Craft::$app->sections->getSectionByUid($uids[0]);
        if (!$section) {
            throw new SectionNotFoundException("Section with uid:$uids[0] not found");
        }

        $types = $section->getEntryTypes();
        $type = ArrayHelper::firstWhere($types, 'uid', $uids[1]);
        if (!$type) {
            throw new EntryTypeNotFoundException("Type with uid:$uids[1] not found");
        }

        $field = Craft::$app->fields->getFieldByUid($uids[2]);
        if (!$field) {
            throw new InvalidFieldException("Field with uid:$uids[2] not found");
        }

        return Craft::$app->view->renderTemplate('genericfields/reverse-relation.twig', [
            'element' => $element,
            'section' => $section,
            'type' => $type,
            'field' => $field,
            'caption' => $this->caption,
            'orderBy' => $this->orderBy,
        ]);
    }

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function getSettingsHtml(): ?string
    {
        return Cp::selectFieldHtml([
                'label' => 'Relationship Source',
                'id' => 'source',
                'name' => 'source',
                'value' => $this->source,
                'required' => true,
                'instructions' => 'Handle relations from this source, having the currently edited entry as a target',
                'options' => $this->_getSourceOptions(),
                'errors' => $this->getErrors('source'),
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

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    protected function _getSourceOptions(): array
    {
        $options = [];

        $sections = Craft::$app->sections->getAllSections();
        foreach ($sections as $section) {
            if ($section->type == Section::TYPE_SINGLE) {
                continue;
            }
            $types = $section->getEntryTypes();
            foreach ($types as $type) {
                $fields = $type->getFieldLayout()->getFields();
                foreach ($fields as $field) {
                    if ($field instanceof Entries) {
                        $options[] = [
                            'label' => "Section: $section->name ($type->name) -> Field: $field->name",
                            'value' => "$section->uid/$type->uid/$field->uid"
                        ];
                    }
                }
            }
        }

        return $options;
    }
}
