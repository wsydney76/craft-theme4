<?php

namespace modules\main\controllers;

use Craft;
use craft\web\Controller;
use function Arrayy\array_last;
use function explode;

class ContentController extends Controller
{
    /**
     * Requires 'generateTransformsBeforePageLoad' => true
     *
     * @return \craft\web\Response|string|\yii\console\Response
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionPrivateImage()
    {
        $path = Craft::$app->request->getRequiredParam('path');

        $fileName = array_last(explode('/',$path));

        $volume = Craft::$app->volumes->getVolumeByHandle('private');
        if (!$volume) {
            return '';
        }

        $basePath = Craft::parseEnv($volume->path);
        $filePath = $basePath . $path;


        return Craft::$app->response->sendFile($filePath, $fileName, [
            'inline' => true
            ]);
    }
}
