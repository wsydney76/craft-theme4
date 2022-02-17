<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;
use craft\elements\Entry;
use craft\elements\User;
use craft\helpers\ArrayHelper;
use http\Exception\InvalidArgumentException;
use function var_dump;

/**
 * m211224_143412_create_entries migration.
 */
class m211224_143412_create_entries extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $user = User::find()->admin()->one();

        // Article Index -------------------------------------------------------------------------------

        $section = Craft::$app->sections->getSectionByHandle('page');
        $type = ArrayHelper::firstWhere($section->getEntryTypes(), 'handle', 'indexPage');

        $entry = new Entry([
            'sectionId' => $section->id,
            'typeId' => $type->id,
            'authorId' => $user->id,
            'title' => 'Artikel',
            'slug' => 'artikel',
            'indexSection' => 'article',
            'orderBy' => '',
            'indexTemplate' => 'cards.twig'
        ]);

        if (!Craft::$app->elements->saveElement($entry)) {
            echo "Error saving article index entry\n";
        }

        // Topics Index -------------------------------------------------------------------------------

        $section = Craft::$app->sections->getSectionByHandle('page');
        $type = ArrayHelper::firstWhere($section->getEntryTypes(), 'handle', 'indexPage');

        $entry = new Entry([
            'sectionId' => $section->id,
            'typeId' => $type->id,
            'authorId' => $user->id,
            'title' => 'Themen',
            'slug' => 'themen',
            'indexSection' => 'topic',
            'orderBy' => 'title',
            'indexTemplate' => 'default.twig'
        ]);

        if (!Craft::$app->elements->saveElement($entry)) {
            echo "Error saving topic index entry\n";
        }

        // About page -------------------------------------------------------------------------------

        $type = ArrayHelper::firstWhere($section->getEntryTypes(), 'handle', 'page');

        $entry = new Entry([
            'sectionId' => $section->id,
            'typeId' => $type->id,
            'authorId' => $user->id,
            'title' => 'Über uns',
            'slug' => 'ueber-uns'
        ]);

        $entry->setFieldValue('bodyContent', [
            'sortOrder' => ['new1','new2'],
            'blocks' => [
                'new1' => [
                    'type' => 'heading',
                    'fields' => [
                        'heading' => 'Kontakt'
                    ]
                ],
                'new2' => [
                    'type' => 'dynamicBlock',
                    'fields' => [
                        'template' => 'contact.twig'
                    ]
                ]
            ]
        ]);

        if (!Craft::$app->elements->saveElement($entry)) {
            echo "Error saving about entry\n";
        }

        // Search Page -------------------------------------------------------------------------------

        $type = ArrayHelper::firstWhere($section->getEntryTypes(), 'handle', 'page');

        $entry = new Entry([
            'sectionId' => $section->id,
            'typeId' => $type->id,
            'authorId' => $user->id,
            'title' => 'Suche',
            'slug' => 'Suche'
        ]);

        $entry->setFieldValue('bodyContent', [
            'sortOrder' => ['new1'],
            'blocks' => [
                'new1' => [
                    'type' => 'dynamicBlock',
                    'fields' => [
                        'template' => 'search.twig'
                    ]
                ]
            ]
        ]);

        if (!Craft::$app->elements->saveElement($entry)) {
            echo "Error saving search entry\n";
        }


        // Impressum  -------------------------------------------------------------------------------

        $section = Craft::$app->sections->getSectionByHandle('legal');

        $type = ArrayHelper::firstWhere($section->getEntryTypes(), 'handle', 'legal');

        $entry = new Entry([
            'sectionId' => $section->id,
            'typeId' => $type->id,
            'authorId' => $user->id,
            'title' => 'Impressum',
            'slug' => 'impressum'
        ]);

        $entry->setFieldValue('bodyContent', [
            'sortOrder' => ['new1','new2'],
            'blocks' => [
                'new1' => [
                    'type' => 'heading',
                    'fields' => [
                        'heading' => 'Kontakt'
                    ]
                ],
                'new2' => [
                    'type' => 'dynamicBlock',
                    'fields' => [
                        'template' => 'contact.twig'
                    ]
                ]
            ]
        ]);

        if (!Craft::$app->elements->saveElement($entry)) {
            echo "Error saving impressum entry\n";
        }

        // Privacy page -------------------------------------------------------------------------------

        $type = ArrayHelper::firstWhere($section->getEntryTypes(), 'handle', 'privacy');

        $entry = new Entry([
            'sectionId' => $section->id,
            'typeId' => $type->id,
            'authorId' => $user->id,
            'title' => 'Datenschutzerklärung',
            'slug' => 'datenschutzerklaerung',
            'showPrivacySettings' => 'mediaCookies'
        ]);

        if (!Craft::$app->elements->saveElement($entry)) {
            echo "Error saving privacy entry\n";
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "There is nothing to revert.\n";
        return true;
    }
}
