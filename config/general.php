<?php
/**
 * General Configuration
 *
 * All of your system's general configuration settings go in here. You can see a
 * list of the available settings in vendor/craftcms/cms/src/config/GeneralConfig.php.
 *
 * @see \craft\config\GeneralConfig
 */

use config\Env;

Env::setCpVars();

return [
    // Global settings
    '*' => [
        // Default Week Start Day (0 = Sunday, 1 = Monday...)
        'defaultWeekStartDay' => 1,

        // Whether generated URLs should omit "index.php"
        'omitScriptNameInUrls' => true,

        // Control Panel trigger word
        'cpTrigger' => 'admin',

        // Whether images transforms should be generated before page load
        'generateTransformsBeforePageLoad' => true,

        // Whether Craft should optimize images for reduced file sizes without noticeably reducing image quality.
        'optimizeImageFilesize' => false,

        // List of file extensions that will be merged into the allowedFileExtensions config setting.

        // Images with a URL like https://pbs.twimg.com/media/FKIjjjqXwAUE3xS?format=jpg&name=large
        // may be saved with a '.jfif' extension when 'save image as' is selected.
        // This can be fixed by setting the Windows registry key
        // Computer\HKEY_CLASSES_ROOT\MIME\Database\Content Type\image/jpeg -> Extension = '.jpg'
        // If this fix is not applied, we allow the extension here and change it in
        // \modules\main\MainModule::init() (Asset::EVENT_AFTER_SAVE)
        'extraAllowedFileExtensions' => [
            'jfif'
        ],

        // The secure key Craft will use for hashing and encrypting data
        'securityKey' => Env::SECURITY_KEY,

        // Whether iFrame Resizer options (opens new window)should be used for Live Preview.
        'useIframeResizer' => true,

        // needs php.ini max upload size and max post size set accordingly
        'maxUploadFileSize' => '512M',

        // Whether uploaded filenames with non-ASCII characters should be converted to ASCII
        'convertFilenamesToAscii' => true,

        // Whether asset URLs should be revved so browsers don’t load cached versions when they’re modified.
        // 'revAssetUrls' => true breaks audio player
        'revAssetUrls' => true,

        // Whether to enable Craft’s template {% cache %} tag on a global basis.
        'enableTemplateCaching' => false,

        //Whether non-ASCII characters in auto-generated slugs should be converted to ASCII
        'limitAutoSlugsToAscii' => true,

        // Max No. of revisions
        'maxRevisions' => 3,

        'aliases' => [

            // Prevent the @web alias from being set automatically (cache poisoning vulnerability)
            '@web' => Env::DEFAULT_SITE_URL,

            // Base Url
            '@baseurl' => Env::DEFAULT_SITE_URL,

            // Lets `./craft clear-caches all` clear CP resources cache
            '@webroot' => dirname(__DIR__) . '/web',

        ],

        // Whether Craft should run pending queue jobs automatically when someone visits the control panel.
        // Run php craft queue/listen if set to false
        'runQueueAutomatically' => Env::RUN_QUEUE_AUTOMATICALLY,

        // When true, Craft will always return a successful response in the “forgot password” flow, making it difficult to enumerate users.
        'preventUserEnumeration' => true,

        // The URI Craft should use for user login on the front end.
        'loginPath' => [
            'de' => 'mitglieder/login',
            'en' => 'members/login'
        ],

        // The URI or URL that Craft should use for Set Password forms on the front end.
        'setPasswordPath' => [
            'de' => 'mitglieder/passwort-vergeben',
            'en' => 'members/set-password',
        ],

        // Whether users should automatically be logged in after activating their account or resetting their password.
        'autoLoginAfterAccountActivation' => true,

        // The URI that users without access to the control panel should be redirected to after activating their account.
        'activateAccountSuccessPath' => [
            'de' => 'mitglieder',
            'en' => 'members',
        ],

        // The URI Craft should redirect to when user token validation fails
        'invalidUserTokenPath' => [
            'de' => 'mitglieder/ungueltig',
            'en' => 'members/invalid',
        ],

    ],

    // Dev environment settings
    'dev' => [
        // Dev Mode (see https://craftcms.com/guides/what-dev-mode-does)
        'devMode' => true,
    ],

    // Staging environment settings
    'staging' => [
        // Set this to `false` to prevent administrative changes from being made on staging
        'allowAdminChanges' => true,
    ],

    // Production environment settings
    'production' => [
        // Set this to `false` to prevent administrative changes from being made on production
        'allowAdminChanges' => false,
        'enableTemplateCaching' => true,
    ],
];
