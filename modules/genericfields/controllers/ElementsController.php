<?php

namespace modules\genericfields\controllers;

use Craft;
use craft\base\Element;
use craft\base\ElementInterface;
use craft\elements\Entry;
use craft\helpers\ElementHelper;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;
use function implode;
use function sprintf;

class ElementsController extends \craft\controllers\ElementsController
{
    public function actionCreate(): \yii\web\Response
    {
        $data = $this->request->getBodyParams();

        $element = new Entry([
            'sectionId' => $data['sectionId'],
            'typeId' => $data['typeId'],
            'siteId' => $data['siteId'],
            'authorId' => $data['authorId'],
        ]);
        $element->setFieldValue($data['field'], [$data['entryId']]);

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

    public function actionRemoveRelationship(): Response
    {

        $data = $this->request->getBodyParams();

        $task = $data['task'];

        $element = Entry::find()->id($data['sourceId'])->siteId($data['siteId'])->status(null)->one();
        if (!$element) {
            throw new NotFoundHttpException();
        }


        $msg = [
            'remove-relationship' => 'Relationship removed',
            'disable-entry' => 'Entry disabled',
            'enable-entry' => 'Entry enabled',
            'delete-entry' => 'Entry deleted'

        ];

        if ($task == 'remove-relationship') {
            $ids = $element->getFieldValue($data['field'])->ids();
            if (($key = array_search($data['targetId'], $ids)) !== false) {
                unset($ids[$key]);
            }

            $element->setFieldValue($data['field'], $ids);
        }

        if($task == 'disable-entry') {
            $element->enabled = false;
        }

        if($task == 'enable-entry') {
            $element->enabled = true;
        }

        if($task == 'delete-entry') {
            if (!Craft::$app->elements->deleteElement($element)) {
                throw new ServerErrorHttpException('Unable to delete entry');
            }
        } else {
            $element->scenario = Element::SCENARIO_ESSENTIALS;
            if (!Craft::$app->elements->saveElement($element)) {
                throw new ServerErrorHttpException(sprintf('Unable to save entry: %s', implode(', ', $element->getErrorSummary(true))));
            }
        }

        return $this->asJson(['success' => true, 'msg' => $msg[$task]]);
    }

    public function actionGetRelatedEntriesListHtml(): string
    {

        $data = $this->request->getBodyParams();
        $props = $data['props'];

        $element = Entry::find()->id($props['elementId'])->siteId($props['siteId'])->status(null)->one();
        if (!$element) {
            throw new NotFoundHttpException();
        }

        return $this->view->renderTemplate('genericfields/reverse-relation-entries-list', [
            'props' => $props
        ]);

    }

    // From ElementsController, copied here because it's private
    private function _asSuccess(string $message, ElementInterface $element, array $data = [], bool $addAnother = false): Response
    {
        return $this->asModelSuccess($element, $message, 'element', $data);
    }
}
