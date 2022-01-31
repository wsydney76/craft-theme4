<?php

namespace modules\main\console\controllers;

use Craft;
use craft\console\Controller;
use craft\elements\Asset;
use craft\elements\Entry;
use craft\elements\User;
use craft\helpers\ArrayHelper;
use Faker\Factory;
use Faker\Generator;
use yii\helpers\Console;
use function implode;
use const PHP_EOL;

class SeedController extends Controller
{
    public const NUM_ENTRIES = 10;
    public const SECTIONHANDLE = 'article';
    public $categorySlug = 'beispiele';
    public $volume = 'images';

    public function actionCreateMembersEntries()
    {

        $entry = Entry::find()->section('page')->type('members')->slug('members')->one();
        if ($entry) {
            $this->stdout('Membership Entries exist');
            return;
        }

        if (!$this->confirm('Create Membership Entries?')) {
            return;
        }

        $section = Craft::$app->sections->getSectionByHandle('page');
        $type = ArrayHelper::firstWhere($section->getEntryTypes(), 'handle', 'members');
        $user = User::find()->admin()->one();

        $entry = new Entry([
            'sectionId' => $section->id,
            'typeId' => $type->id,
            'authorId' => $user->id,
            'title' => 'Mitglieder',
            'slug' => 'mitglieder'
        ]);
        $entry->setFieldValue('membersTemplate', 'members.twig');

        if (Craft::$app->elements->saveElement($entry)) {
            $this->stdout('Members done, ID:' . $entry->id . PHP_EOL);
        } else {
            $this->stderr('failed: ' . implode(', ', $entry->getErrorSummary(true)) . PHP_EOL, Console::FG_RED);
            return;
        }

        $parent = $entry;
        $items = [
            ['title' => 'Login', 'slug' => 'login', 'membersTemplate' => 'login.twig'],
            ['title' => 'Registrieren', 'slug' => 'register', 'membersTemplate' => 'register.twig'],
            ['title' => 'Profil', 'slug' => 'profil', 'membersTemplate' => 'profile.twig'],
            ['title' => 'Passwort vergessen?', 'slug' => 'forgotpassword', 'membersTemplate' => 'forgotpassword.twig'],
            ['title' => 'Passwort vergeben', 'slug' => 'setpassword', 'membersTemplate' => 'setpassword.twig'],
            ['title' => 'Ungültig', 'slug' => 'setpassword', 'membersTemplate' => 'invalidtoken.twig'],
        ];

        foreach ($items as $item) {

            $entry = new Entry([
                'sectionId' => $section->id,
                'typeId' => $type->id,
                'authorId' => $user->id,
                'title' => $item['title'],
                'slug' => $item['slug'],
                'newParentId' => $parent->id
            ]);
            $entry->setFieldValue('membersTemplate', $item['membersTemplate']);

            if (Craft::$app->elements->saveElement($entry)) {
                $this->stdout($item['title'] . ' done, ID:' . $entry->id . PHP_EOL);
            } else {
                $this->stderr($item['title'] . ' failed: ' . implode(', ', $entry->getErrorSummary(true)) . PHP_EOL, Console::FG_RED);
                return;
            }
        }
    }

    public function actionCreateEntries(int $num = self::NUM_ENTRIES, $sectionHandle = self::SECTIONHANDLE)
    {
        $section = Craft::$app->sections->getSectionByHandle($sectionHandle);
        if (!$section) {
            $this->stderr("Invalid section {$sectionHandle}") . PHP_EOL;
            return;
        }

        if (!$this->confirm("Create {$num} entries of type '{$section->name}'?")) {
            return;
        }

        $faker = Factory::create();

        $type = $section->getEntryTypes()[0];
        $user = User::find()->admin()->one();

        // $category = $this->getCategory();

        for ($i = 1; $i <= $num; $i++) {
            $entry = new Entry();
            $entry->sectionId = $section->id;
            $entry->typeId = $type->id;
            $entry->authorId = $user->id;
            $entry->postDate = $faker->dateTimeInInterval('-14 days', '-3 months');

            $title = $faker->text(50);
            $this->stdout("[{$i}/{$num}] Creating {$title} ... ");

            $entry->title = $title;
            $entry->setFieldValue('teaser', $faker->text(50));

            $image = $this->getRandomImage(900);
            if ($image) {
                $entry->setFieldValue('featuredImage', [$image->id]);
            }

//            if ($category && $sectionHandle == 'article') {
//                $entry->setFieldValue('categories', [$category->id]);
//            }

            $entry->setFieldValue('bodyContent', $this->getBodyContent($faker));

            if (Craft::$app->elements->saveElement($entry)) {
                $this->stdout('done, ID:' . $entry->id . PHP_EOL);
            } else {
                $this->stderr('failed: ' . implode(', ', $entry->getErrorSummary(true)) . PHP_EOL, Console::FG_RED);
            }
        }
    }

    protected function getBodyContent(Generator $faker)
    {

        $content = [
            'sortOrder' => [],
            'blocks' => []
        ];

        $layouts = [
            ['text', 'heading', 'image', 'text', 'image'],
            ['image', 'text', 'heading', 'text', 'quote', 'text', 'gallery'],
            ['text', 'text', 'text', 'heading', 'text', 'text', 'text', 'heading', 'text', 'text', 'text'],
            ['image', 'image', 'image'],
            ['text', 'text', 'quote', 'text', 'image'],
            ['heading', 'text', 'text', 'heading', 'text', 'quote'],
            ['text', 'heading', 'gallery']
        ];

        $blockTypes = $faker->randomElement($layouts);

        $i = 0;
        foreach ($blockTypes as $blockType) {

            switch ($blockType) {
                case 'text':
                    $block = [
                        'type' => 'text',
                        'fields' => [
                            'text' => $faker->paragraphs($faker->numberBetween(1, 5), true)
                        ]
                    ];
                    break;
                case 'heading':
                    $block = [
                        'type' => 'heading',
                        'fields' => [
                            'heading' => $faker->text(40)
                        ]
                    ];
                    break;
                case 'image':
                    $image = $this->getRandomImage(900);
                    $block = [
                        'type' => 'image',
                        'fields' => [
                            'image' => $image ? [$image->id] : null,
                            'caption' => $faker->text(30)
                        ]
                    ];
                    break;
                case 'gallery':
                    $imageIds = [];
                    for ($img = 0; $img < 6; $img++) {
                        $image = $this->getRandomImage(500);
                        if ($image) {
                            $imageIds[] = $image->id;
                        }
                    }
                    $block = [
                        'type' => 'gallery',
                        'fields' => [
                            'images' => $imageIds
                        ]
                    ];
                    break;
                case 'quote':
                    $block = [
                        'type' => 'quote',
                        'fields' => [
                            'text' => $faker->text(80),
                            'attribution' => $faker->name
                        ]
                    ];
                    break;
            }

            $i++;
            $id = "new{$i}";
            $content['sortOrder'][] = $id;
            $content['blocks'][$id] = $block;
        }

        $id = 'newExample';
        $content['sortOrder'][] = $id;
        $content['blocks'][$id] = [
            'blockType' => 'text',
            'fields' => [
                'text' => 'This is an autogenerated example entry.'
            ]
        ];

        return $content;
    }

    protected function getRandomImage($width = 1900)
    {
        return Asset::find()
            ->volume($this->volume)
            ->kind('image')
            ->width('> ' . $width)
            ->orderBy(Craft::$app->db->driverName == 'mysql' ? 'RAND()' : 'RANDOM()')
            ->one();
    }

    public function actionDeleteFakedEntries()
    {
        $category = Entry::find()->section('category')->slug($this->categorySlug)->one();
        if (!$category) {
            $this->stderr('No example category found');
            return;
        }
        $entries = Entry::find()->section('article')->relatedTo($category)->anyStatus()->all();
        if (!$entries) {
            $this->stderr('No example posts found');
            return;
        }
        $count = count($entries);
        if (!$this->confirm("Delete {$count} posts related to category {$category->title}?")) {
            return;
        }
        foreach ($entries as $entry) {
            $this->stdout("Deleting {$entry->title}" . PHP_EOL);
            Craft::$app->elements->deleteElement($entry);
        }
        if (!$this->confirm("Delete example category?")) {
            return;
        }
        Craft::$app->elements->deleteElement($category);

        $this->stdout('The entries have been soft-deleted, they can be restored from the entries index.' . PHP_EOL);
    }

    protected function getCategory()
    {
        $entry = Entry::find()->section('category')->slug($this->categorySlug)->one();
        if (!$entry) {
            $section = Craft::$app->sections->getSectionByHandle('category');
            if (!$section) {
                return $entry;
            }
            $type = $section->getEntryTypes()[0];
            $user = User::find()->admin()->one();
            $entry = new Entry();
            $entry->sectionId = $section->id;
            $entry->typeId = $type->id;
            $entry->authorId = $user->id;
            $entry->title = 'Beispiele';
            $entry->slug = $this->categorySlug;
            $entry->setFieldValue('teaser', 'Collection of auto-generated examples');
            $this->stdout('Creating Example Content Category ... ');

            if (!Craft::$app->elements->saveElement($entry)) {
                $this->stderr('failed: ' . implode(', ', $entry->getErrorSummary(true)) . PHP_EOL, Console::FG_RED);
            } else {
                $localEntry = $entry->getLocalized()->one();
                if ($localEntry) {
                    $localEntry->title = 'Examples';
                    $localEntry->slug = 'examples';
                    $localEntry->setFieldValue('teaser', 'Sammlung von automatisch generierten Beispielen');
                    Craft::$app->elements->saveElement($localEntry);
                }
                $this->stdout('done' . PHP_EOL);
            }
        }
        return $entry;
    }
}
