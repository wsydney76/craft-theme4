<?php

$theme = Craft::$app->config->getConfigFromFile('theme');

return [
    'isCoverTitleStyle' => in_array($theme['titleStyle'], $theme['showIncreaseTitleContrastInput'], true)
];
