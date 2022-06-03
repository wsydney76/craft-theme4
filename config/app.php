<?php
/**
 * Yii Application Config
 *
 * Edit this file at your own risk!
 *
 * The array returned by this file will get merged with
 * vendor/craftcms/cms/src/config/app.php and app.[web|console].php, when
 * Craft's bootstrap script is defining the configuration for the entire
 * application.
 *
 * You can define custom modules and system components, and even override the
 * built-in system components.
 *
 * If you want to modify the application config for *only* web requests or
 * *only* console requests, create an app.web.php or app.console.php file in
 * your config/ folder, alongside this one.
 */

use config\Env;
use craft\db\Table;
use craft\helpers\App;
use modules\guide\GuideModule;
use modules\main\MainModule;
use yii\web\DbSession;

return [
    'id' => Env::APP_ID,
    'modules' => [
        'main' => MainModule::class,
        'guide' => GuideModule::class
    ],
    'bootstrap' => [
        'main',
        'guide'
    ],
    'components' => [
        'session' => function() {
            // Get the default component config
            $config = App::sessionConfig();

            // Override the class to use DB session class
            $config['class'] = DbSession::class;

            // Set the session table name
            $config['sessionTable'] = Table::PHPSESSIONS;

            // Instantiate and return it
            return Craft::createObject($config);
        },
    ],
];
