<?php

namespace modules\main\controllers;

use Craft;
use craft\elements\Entry;
use craft\elements\GlobalSet;
use craft\helpers\App;
use craft\web\Controller;
use craft\web\Response;
use modules\main\models\MessageModel;
use yii\web\BadRequestHttpException;
use function Arrayy\array_last;
use function explode;

class ContentController extends Controller
{
    protected $allowAnonymous = ['send-message'];

    /**
     * Requires 'generateTransformsBeforePageLoad' => true
     *
     * @throws BadRequestHttpException
     */
    public function actionPrivateImage(): string|Response
    {
        $path = Craft::$app->request->getRequiredParam('path');

        $fileName = array_last(explode('/', $path));

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

    public function actionSendMessage(): ?\yii\web\Response
    {
        $input = Craft::$app->request->getRequiredBodyParam('message');

        $message = new MessageModel($input);

        if (!$message->validate()) {
            $this->setFailFlash(Craft::t('site', 'Error validating message'));
            Craft::$app->urlManager->setRouteParams(['message' => $message]);
            return null;
        }

        $id = Craft::$app->request->getBodyParam('id');
        if ($id) {
            $recipientId = Craft::$app->security->validateData($id);
            if (!$recipientId) {
                throw new BadRequestHttpException();
            }

            $recipient = Entry::find()->id($recipientId)->one();
            if (!$recipient) {
                throw new BadRequestHttpException();
            }

            $email = $recipient->email ?? $recipient->author->email;
        } else {
            $siteInfo = GlobalSet::find()->handle('siteInfo')->one();
            $email = $siteInfo->email;
        }

        if (!Craft::$app->mailer->compose()
            ->setFrom([$message->email => $message->name])
            ->setTo($email)
            ->setSubject($message->subject)
            ->setTextBody($message->message)
            ->send()) {
            Craft::$app->session->setError('System error sending message');
            Craft::$app->urlManager->setRouteParams(['message' => $message]);
            return null;
        }

        $this->setSuccessFlash(Craft::t('site', 'Message sent'));
        return $this->redirectToPostedUrl(['id' => $id]);
    }
}
