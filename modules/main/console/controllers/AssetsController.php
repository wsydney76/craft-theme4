<?php

namespace modules\main\console\controllers;

use Craft;
use craft\console\Controller;
use craft\db\Table;
use craft\helpers\App;
use craft\models\Volume;
use modules\main\helpers\FileHelper;
use yii\console\ExitCode;
use yii\db\Exception;

class AssetsController extends Controller
{
// This is an example, better call a service method in real live.
    //
    // php craft main/assets/clear-image-transform-directories
    //

    /**
     * Clear all image transform stuff
     *
     * @throws Exception
     */
    public function actionClearImageTransformDirectories(): int
    {

        if (Craft::$app->plugins->isPluginEnabled('imager-x')) {
            $this->stdout("Imager-X is enabled, please use it's utilities to clear the cache.");
            return ExitCode::UNSPECIFIED_ERROR;
        }

        if (!$this->confirm('This will delete all image transform data', true)) {
            return ExitCode::OK;
        }

        Craft::$app->getDb()->createCommand()
            ->truncateTable(Table::IMAGETRANSFORMINDEX)
            ->execute();

        $volumes = Craft::$app->volumes->getAllVolumes();

        foreach ($volumes as $volume) {
            $this->_clearVolume($volume);
        }

        echo 'Image Transform Directories cleared';
        return ExitCode::OK;
    }

    private function _clearVolume(Volume $volume): void
    {
        $root = App::parseEnv($volume->getTransformFs()->path);

        FileHelper::clearDirectory($root);
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function actionDeleteEmptyTransformFolders(): int
    {

        if (Craft::$app->plugins->isPluginEnabled('imager-x')) {
            $this->stdout("Imager-X is enabled, please use it's utilities to clear the cache.");
            return ExitCode::UNSPECIFIED_ERROR;
        }

        if (!$this->confirm('Delete empty transform subfolders)', true)) {
            return ExitCode::OK;
        }

        FileHelper::cleanupTransformDirectories();

        return ExitCode::OK;
    }

}
