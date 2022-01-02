<?php

use club\assetrev\utilities\strategies\ManifestFileStrategy;
use config\Env;

return [
    '*' => [
        'strategies' => [
            'manifest' => ManifestFileStrategy::class,
            'noManifest' => function() {
                return '';
            }
        ],
        'assetUrlPrefix' => Env::DEFAULT_SITE_URL,
        'manifestPath' => 'web/assets/dist/manifest.json',
        'pipeline' => 'manifest|noManifest',
    ]
];
