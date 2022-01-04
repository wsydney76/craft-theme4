<?php

namespace craft\contentmigrations;

use Craft;
use craft\base\Field;
use craft\db\Migration;
use craft\elements\User;
use function var_dump;

/**
 * m200501_120937_elementindexes_settings migration.
 */
class m200501_120937_elementindexes_settings extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $sections = Craft::$app->sections->getAllSections();
        $s = [];
        foreach ($sections as $section) {
            $s[$section->handle] = 'section:' . $section->uid;
        }

        $f = [];
        $fields = Craft::$app->fields->getAllFields();
        foreach ($fields as $field) {
            /** @var Field $field */
            $f[$field->handle] = 'field:' . $field->id;
        }

        $entrySettings = [
            'sourceOrder' => [
                ['key', '*'],
                ['heading', 'Site'],
                ['key', 'singles'],
                ['key', $s['page']],
                ['key', $s['article']],
                ['key', $s['legal']],
                ['heading', 'Intern'],
                ['key', $s['guide']]
            ],
            'sources' => [
                '*' => ['tableAttributes' => ['section', 'postDate', 'link']],
                'singles' => ['tableAttributes' => ['drafts', $f['featuredImage'], 'link']],
                $s['page'] => ['tableAttributes' => ['drafts', 'hasProvisionalDraft', 'type', $f['featuredImage'], 'postDate', 'link']],
                $s['article'] => ['tableAttributes' => ['drafts', 'hasProvisionalDraft', $f['featuredImage'], $f['teaser'], 'author', 'postDate', 'link']],
                $s['legal'] => ['tableAttributes' => ['drafts', 'hasProvisionalDraft', $f['featuredImage'], $f['teaser'], 'postDate', 'link']],
                $s['guide'] => ['tableAttributes' => ['drafts', 'author', 'postDate']]

            ]
        ];

        Craft::$app->elementIndexes->saveSettings('craft\\elements\\Entry', $entrySettings);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "There is nothing to be reverted.\n";
        return true;
    }
}
