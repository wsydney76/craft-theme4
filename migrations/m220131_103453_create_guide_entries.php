<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;
use craft\elements\Entry;
use craft\elements\User;
use craft\helpers\ArrayHelper;

/**
 * m220131_103453_create_guide_entries migration.
 */
class m220131_103453_create_guide_entries extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // Guide -------------------------------------------------------------------------------

        $section = Craft::$app->sections->getSectionByHandle('guide');
        $type = ArrayHelper::firstWhere($section->getEntryTypes(), 'handle', 'guide');
        $user = User::find()->admin()->one();

        $guides = [
            ['title' => 'Guide', 'slug' => 'guide'],
            ['title' => 'Inhalt', 'slug' => 'content'],
            ['title' => 'Dateien', 'slug' => 'assets'],
            ['title' => 'Content Builder', 'slug' => 'contentbuilder'],
            ['title' => 'Blöcke', 'slug' => 'blocks'],
            ['title' => 'Markdown', 'slug' => 'markdown'],
            ['title' => 'Sektionen', 'slug' => 'sections'],
            ['title' => 'Artikel', 'slug' => 'article'],
            ['title' => 'Seite', 'slug' => 'page'],
            ['title' => 'Rechtliches', 'slug' => 'legal'],
        ];

        foreach ($guides as $guide) {
            $guideEntry = new Entry([
                'sectionId' => $section->id,
                'typeId' => $type->id,
                'authorId' => $user->id,
                'title' => $guide['title'],
                'slug' => $guide['slug']
            ]);

            if (!Craft::$app->elements->saveElement($guideEntry)) {
                echo "Error saving guide entry #{guide['title']}  \n";
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m220131_103453_create_guide_entries cannot be reverted.\n";
        return true;
    }
}
