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

        $this->setParent('content', ['contentbuilder', 'blocks']);
        $this->setParent('sections', ['article', 'page', 'legal']);

        $this->setIncludeGuides(['article', 'page', 'legal'], ['contentBuilder', 'blocks']);
    }

    protected function setParent($parentSlug, $childrenSlugs)
    {
        $parent = $this->getGuideBySlug($parentSlug);
        if (!$parent) {
            return;
        }

        foreach ($childrenSlugs as $childSlug) {
            /** @var Entry $child */
            $entry = $this->getGuideBySlug($childSlug);

            if (!$entry) {
                continue;
            }
            $entry->newParentId = $parent->id;
            Craft::$app->elements->saveElement($entry);
        }
    }

    protected function setIncludeGuides($sectionSlugs, $includeSlugs)
    {
        $includeIds = [];
        foreach ($includeSlugs as $includeSlug) {
            $entry = $this->getGuideBySlug($includeSlug);

            if (!$entry) {
                continue;
            }
            $includeIds[] = $entry->id;
        }

        if (!$includeIds) {
            return;
        }

        foreach ($sectionSlugs as $sectionSlug) {
            $entry = $this->getGuideBySlug($sectionSlug);

            if (!$entry) {
                continue;
            }

            $entry->setFieldValue('includeGuides', $includeIds);
            Craft::$app->elements->saveElement($entry);
        }
    }

    protected function getGuideBySlug($slug)
    {
        return Entry::find()->section('guide')->slug($slug)->one();
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
