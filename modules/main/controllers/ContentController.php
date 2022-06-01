<?php

namespace modules\main\controllers;

use Craft;
use craft\base\Element;
use craft\base\ElementInterface;
use craft\elements\Entry;
use craft\helpers\App;
use craft\helpers\ElementHelper;
use craft\web\Controller;
use craft\web\Response;
use modules\main\MainModule;
use modules\main\models\MessageModel;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;
use function Arrayy\array_last;
use function explode;
use function implode;
use function sprintf;

class ContentController extends Controller
{
    protected array|int|bool $allowAnonymous = ['send-message'];

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
            $validatedId = Craft::$app->security->validateData($id);
            if (!$validatedId) {
                throw new BadRequestHttpException();
            }
        } else {
            $validatedId = null;
        }

        if (!MainModule::getInstance()->content->sendMessage($message, $validatedId)) {
            Craft::$app->session->setError('System error sending message');
            Craft::$app->urlManager->setRouteParams(['message' => $message]);
            return null;
        }

        $this->setSuccessFlash(Craft::t('site', 'Message sent'));
        return $this->redirectToPostedUrl((object)['id' => $id]);
    }

    public function actionCreateAuthorPersonEntry(): \yii\web\Response
    {
        $data = $this->request->getBodyParams();

        $element = new Entry([
            'sectionId' => $data['sectionId'],
            'typeId' => $data['typeId'],
            'siteId' => $data['siteId'],
            'authorId' => $data['authorId'],
        ]);
        $element->setFieldValue('user', [$data['userId']]);
        $element->setFieldValue('email', $data['email']);
        $element->setFieldValue('firstName', $data['firstName']);
        $element->setFieldValue('lastName', $data['lastName']);

        if (!$element->slug) {
            $element->slug = ElementHelper::tempSlug();
        }

        $element->setScenario(Element::SCENARIO_ESSENTIALS);
        if (!Craft::$app->getDrafts()->saveElementAsDraft($element, $data['authorId'], null, null, false)) {
            throw new ServerErrorHttpException(sprintf('Unable to save draft: %s', implode(', ', $element->getErrorSummary(true))));
        }

        return $this->_asSuccess(Craft::t('app', '{type} created.', [
            'type' => Craft::t('app', 'Draft'),
        ]), $element);
    }

    // From ElementsController, copied here because it's private
    private function _asSuccess(string $message, ElementInterface $element, array $data = [], bool $addAnother = false): \yii\web\Response
    {
        return $this->asModelSuccess($element, $message, 'element', $data);
    }
}
