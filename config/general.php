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

        //Whether non-ASCII characters in auto-generated slugs should be converted to ASCII
        'limitAutoSlugsToAscii' => true,

        'maxRevisions' => 10,

        'aliases' => [

            // Prevent the @web alias from being set automatically (cache poisoning vulnerability)
            '@web' => Env::DEFAULT_SITE_URL,

            // Base Url
            '@baseurl' => Env::DEFAULT_SITE_URL,

            // Lets `./craft clear-caches all` clear CP resources cache
            '@webroot' => dirname(__DIR__) . '/web',

        ],
    ],

    // Dev environment settings
    'dev' => [
        // Dev Mode (see https://craftcms.com/guides/what-dev-mode-does)
        'devMode' => true,
        'enableTemplateCaching' => false,
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
    ],
];
