<?php

namespace modules\main\console\controllers;

use Craft;
use craft\console\Controller;
use craft\elements\Entry;
use craft\elements\GlobalSet;
use craft\elements\User;
use craft\helpers\App;
use craft\helpers\ArrayHelper;
use craft\helpers\Assets;
use Faker\Factory;
use yii\console\ExitCode;
use function array_diff;
use function copy;
use function pathinfo;
use function scandir;
use function var_dump;
use const DIRECTORY_SEPARATOR;
use const PHP_EOL;

class InitController extends Controller
{

    /**
     * @var string
     */
    public $defaultAction = 'all';

    public function actionAll(): int
    {

        if ($this->interactive && !$this->confirm('Run all init actions? This should only be done once, immediately after installing.')) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $this->stdout('Setting some global content...');
        $this->actionSetup();
        $this->stdout(PHP_EOL);

        $this->stdout('Create one-off pages...');
        $this->actionCreateEntries();
        $this->stdout(PHP_EOL);

        $this->stdout('Create Guides...');
        $this->actionCreateGuideEntries();
        $this->stdout(PHP_EOL);

        $this->stdout('Update Users...');
        $this->actionSetUsers();
        $this->stdout(PHP_EOL);

        return ExitCode::OK;
    }

    public function actionSetup(): int
    {
        $faker = Factory::create();

        // Give the homepage some content
        $entry = Entry::find()->section('homepage')->one();

        $paragraphs = '';
        foreach ($faker->paragraphs($faker->numberBetween(3, 6)) as $paragraph) {
            $paragraphs .= '<p>' . $paragraph . '</p>';
        }

        $entry->setFieldValue('bodyContent', [
            'sortOrder' => ['new1', 'new2', 'new3', 'new4'],
            'blocks' => [
                'new1' => [
                    'type' => 'summary',
                    'fields' => [
                        'heading' => 'Dies ist automatisch generierter Inhalt',
                        'text' => $faker->paragraphs($faker->numberBetween(2, 3), true)
                    ]
                ],
                'new2' => [
                    'type' => 'text',
                    'fields' => [
                        'text' => $paragraphs
                    ]
                ],
                'new3' => [
                    'type' => 'heading',
                    'fields' => [
                        'heading' => 'Neue Artikel'
                    ]
                ],
                'new4' => [
                    'type' => 'dynamicBlock',
                    'fields' => [
                        'template' => 'cards.twig',
                        'parameter' => '{"section":"article","limit":3}'
                    ]
                ]
            ]
        ]);

        if (!Craft::$app->elements->saveElement($entry)) {
            echo "Error saving homepage entry\n";
        }

        // Translate Message Entry
        $entry = Entry::find()->section('message')->site('de')->one();
        if ($entry) {
            $entry->title = 'Nachricht';
            $entry->slug = 'nachricht';
            if (!Craft::$app->elements->saveElement($entry)) {
                echo "Error saving message entry\n";
            }
        }

        // Set Globals
        $global = GlobalSet::find()->handle('siteInfo')->one();
        if ($global) {
            $global->setFieldValue('siteName', 'Starter');
            $global->setFieldValue('copyright', 'Starter GmbH');
            $global->setFieldValue('cookieConsentText', 'Wir verwenden manchmal Cookies');
            $global->setFieldValue('cookieConsentInfo', $faker->paragraphs($faker->numberBetween(2, 5), true));
            $global->setFieldValue('individualContact', $faker->paragraphs($faker->numberBetween(2, 3), true));
            $global->setFieldValue('email', $faker->email());
            $global->setFieldValue('telephone', $faker->phoneNumber());
            $global->setFieldValue('fax', $faker->phoneNumber());
            Craft::$app->elements->saveElement($global);
        }

        return ExitCode::OK;
    }

    public function actionCreateEntries(): int
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
            'indexTemplate' => 'cards.twig',
            'criteria' => '{"section":"article", "orderBy":"postDate desc", "limit":12, "with": [["featuredImage"],["author"]]}'
        ]);

        if (!Craft::$app->elements->saveElement($entry)) {
            echo "Error saving article index entry\n";
        } else {
            $this->localize($entry, 'Articles', 'articles');
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
            'indexTemplate' => 'default.twig',
            'criteria' => '{"section":"topic", "orderBy":"postDate desc", "limit":12, "with": [["featuredImage"]]}'
        ]);

        if (!Craft::$app->elements->saveElement($entry)) {
            echo "Error saving topic index entry\n";
        } else {
            $this->localize($entry, 'Topics', 'topics');
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
            'sortOrder' => ['new1', 'new2'],
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
        } else {
            $this->localize($entry, 'Contact', 'contact');
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
        } else {
            $this->localize($entry, 'Search', 'search');
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
            'sortOrder' => ['new1', 'new2'],
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
        } else {
            $this->localize($entry, 'Imprint', 'imprint');
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
        } else {
            $this->localize($entry, 'Privacy policy', 'privacy');
        }

        return ExitCode::OK;
    }

    protected function localize($entry, $title, $slug)
    {
        $localizedEntry = $entry->getLocalized()->site('en')->one();
        if ($localizedEntry) {
            $localizedEntry->title = $title;
            $localizedEntry->slug = $slug;
            Craft::$app->elements->saveElement($localizedEntry);
        }
    }

    public function actionCreateGuideEntries(): int
    {
        // Guide -------------------------------------------------------------------------------

        $section = Craft::$app->sections->getSectionByHandle('guide');
        $type = ArrayHelper::firstWhere($section->getEntryTypes(), 'handle', 'guide');
        $user = User::find()->admin()->one();

        $guides = [
            ['title' => 'Guide', 'slug' => 'guide', 'admin' => 0],
            ['title' => 'Inhalt', 'slug' => 'content', 'admin' => 0],
            ['title' => 'Dateien', 'slug' => 'assets', 'admin' => 0],
            ['title' => 'Content Builder', 'slug' => 'contentbuilder', 'admin' => 0],
            ['title' => 'Blöcke', 'slug' => 'blocks', 'admin' => 0],
            ['title' => 'Sektionen', 'slug' => 'sections', 'admin' => 0],
            ['title' => 'Artikel', 'slug' => 'article', 'admin' => 0],
            ['title' => 'Seite', 'slug' => 'page', 'admin' => 0],
            ['title' => 'Rechtliches', 'slug' => 'legal', 'admin' => 0],
            ['title' => 'Developer', 'slug' => 'admin', 'admin' => 1],
            ['title' => 'Farben', 'slug' => 'colors', 'admin' => 1],
        ];

        foreach ($guides as $guide) {
            $guideEntry = new Entry([
                'sectionId' => $section->id,
                'typeId' => $type->id,
                'authorId' => $user->id,
                'title' => $guide['title'],
                'slug' => $guide['slug']
            ]);

            $guideEntry->setFieldValue('adminGuide', $guide['admin']);

            if (!Craft::$app->elements->saveElement($guideEntry)) {
                echo "Error saving guide entry #{guide['title']}  \n";
            }
        }

        $this->setGuideParent('content', ['contentbuilder', 'blocks']);
        $this->setGuideParent('sections', ['article', 'page', 'legal']);
        $this->setGuideParent('admin', ['colors']);

        $this->setIncludeGuides(['article', 'page', 'legal'], ['contentBuilder', 'blocks']);

        return ExitCode::OK;
    }

    protected function setGuideParent($parentSlug, $childrenSlugs): void
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

            // $entry->newParentId = $parent->id;
            $entry->setParentId($parent->id);
            Craft::$app->elements->saveElement($entry);
        }
    }

    protected function getGuideBySlug($slug)
    {
        return Entry::find()->section('guide')->slug($slug)->one();
    }

    protected function setIncludeGuides($sectionSlugs, $includeSlugs): void
    {
        $includeIds = [];
        foreach ($includeSlugs as $includeSlug) {
            $entry = $this->getGuideBySlug($includeSlug);

            if (!$entry) {
                continue;
            }

            $includeIds[] = $entry->id;
        }

        if ($includeIds === []) {
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

    public function actionSetUsers(): int
    {
        $faker = Factory::create();

        // Set admin attributes
        $user = User::find()->one();
        $user->firstName = 'Sabine';
        $user->lastName = 'Mustermann';

        Craft::$app->elements->saveElement($user);

        // Add new user
        $user = new User();
        $user->username = 'erna';
        $user->firstName = 'Erna';
        $user->lastName = 'Klawuppke';
        $user->email = 'erna.klawuppke@example.com';

        $user->setScenario(User::SCENARIO_LIVE);

        if (Craft::$app->elements->saveElement($user)) {
            $group = Craft::$app->userGroups->getGroupByHandle('editors');

            if ($group) {
                Craft::$app->users->assignUserToGroups($user->getId(), [$group->id]);
            }
        } else {
            echo "Error saving user";
        }

        // Create related person entries
        $section = Craft::$app->sections->getSectionByHandle('person');
        $type = ArrayHelper::firstWhere($section->getEntryTypes(), 'handle', 'default');

        $users = User::find()->all();
        foreach ($users as $user) {
            $entry = new Entry([
                'sectionId' => $section->id,
                'typeId' => $type->id,
                'authorId' => $user->id,
                'firstName' => $user->firstName,
                'lastName' => $user->lastName,
                'bio' => $faker->text(120),
                'email' => $user->email
            ]);

            $entry->setFieldValue('user', [$user->id]);

            if (!Craft::$app->elements->saveElement($entry)) {
                echo "Error saving person entry\n";
            }
        }

        // Set user photos
        $sourceDir = App::parseEnv('@storage/rebrand/userphotos');

        $files = scandir($sourceDir);
        $files = array_diff($files, ['.', '..']);

        foreach ($files as $file) {
            $path = $sourceDir . DIRECTORY_SEPARATOR . $file;
            $pathInfo = pathinfo($path);
            $username = $pathInfo['filename'];

            $user = User::find()->username($username)->one();
            if ($user) {
                // saveUserPhoto deletes the file, so making a temporary copy
                $tempPath = Assets::tempFilePath($pathInfo['extension']);
                copy($path, $tempPath);
                Craft::$app->users->saveUserPhoto($tempPath, $user);
            }
        }
        return ExitCode::OK;
    }
}
