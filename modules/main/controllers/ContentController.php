<?php

namespace modules\main\controllers;

use Craft;
use craft\helpers\App;
use craft\web\Controller;

use craft\web\Response;
use yii\web\BadRequestHttpException;
use function Arrayy\array_last;
use function explode;

class ContentController extends Controller
{
    /**
     * Requires 'generateTransformsBeforePageLoad' => true
     *
     * @throws BadRequestHttpException
     */
    public function actionPrivateImage(): string|Response
    {
        $path = Craft::$app->request->getRequiredParam('path');

        $fileName = array_last(explode('/',$path));

        $volume = Craft::$app->volumes->getVolumeByHandle('private');
        if (!$volume) {
            return '';
        }

        $basePath = App::parseEnv($volume->path);
        $filePath = $basePath . $path;


        return Craft::$app->response->sendFile($filePath, $fileName, [
            'inline' => true
            ]);
    }
}
