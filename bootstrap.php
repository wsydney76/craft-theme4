<?php

use config\Env;

// Set path constants
define('CRAFT_BASE_PATH', __DIR__);
define('CRAFT_VENDOR_PATH', CRAFT_BASE_PATH . '/vendor');
define('CRAFT_TEMPLATES_PATH', CRAFT_BASE_PATH . '/templates');

// Load Composer's autoloader
require_once CRAFT_VENDOR_PATH . '/autoload.php';

// Set environment variables for CP
Env::setCpVars();

define('CRAFT_ENVIRONMENT', Env::ENVIRONMENT ?: 'production');
