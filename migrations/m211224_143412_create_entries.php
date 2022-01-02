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

        // Blog Index -------------------------------------------------------------------------------

        $section = Craft::$app->sections->getSectionByHandle('page');
        $type = ArrayHelper::firstWhere($section->getEntryTypes(), 'handle', 'indexPage');

        $entry = new Entry([
            'sectionId' => $section->id,
            'typeId' => $type->id,
            'authorId' => $user->id,
            'title' => 'Blog',
            'slug' => 'blog',
            'indexSection' => 'blog',
            'orderBy' => '',
            'indexTemplate' => 'cards.twig'
        ]);

        if (!Craft::$app->elements->saveElement($entry)) {
            echo "Error saving blog index entry\n";
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

        if (!Craft::$app->elements->saveElement($entry)) {
            echo "Error saving about entry\n";
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

        // Guide -------------------------------------------------------------------------------

        $section = Craft::$app->sections->getSectionByHandle('guide');

        $type = ArrayHelper::firstWhere($section->getEntryTypes(), 'handle', 'guide');

        $guideEntry = new Entry([
            'sectionId' => $section->id,
            'typeId' => $type->id,
            'authorId' => $user->id,
            'title' => 'Guide',
            'slug' => 'guide'
        ]);

        if (!Craft::$app->elements->saveElement($guideEntry)) {
            echo "Error saving guide entry\n";
        }

        // Page guide -------------------------------------------------------------------------------

        $entry = new Entry([
            'sectionId' => $section->id,
            'typeId' => $type->id,
            'authorId' => $user->id,
            'title' => 'Page',
            'slug' => 'page'
        ]);
        $entry->setParent($guideEntry);

        if (!Craft::$app->elements->saveElement($entry)) {
            echo "Error saving page guide entry\n";
        }

        // Blog guide -------------------------------------------------------------------------------

        $entry = new Entry([
            'sectionId' => $section->id,
            'typeId' => $type->id,
            'authorId' => $user->id,
            'title' => 'Blog',
            'slug' => 'blog'
        ]);
        $entry->setParent($guideEntry);

        if (!Craft::$app->elements->saveElement($entry)) {
            echo "Error saving blog guide entry\n";
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
