<?php

namespace modules\main;

use Craft;
use craft\base\conditions\BaseCondition;
use craft\base\Element;
use craft\elements\Asset;
use craft\elements\Entry;
use craft\events\DefineBehaviorsEvent;
use craft\events\DefineRulesEvent;
use craft\events\ElementEvent;
use craft\events\ElementIndexTableAttributeEvent;
use craft\events\ModelEvent;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterConditionRuleTypesEvent;
use craft\events\RegisterElementTableAttributesEvent;
use craft\events\SetElementTableAttributeHtmlEvent;
use craft\helpers\ElementHelper;
use craft\helpers\Html;
use craft\services\Elements;
use craft\services\Fields;
use craft\web\View;
use modules\main\behaviors\EntryBehavior;
use modules\main\conditions\HasDraftsConditionRule;
use modules\main\conditions\HasEmptyAltTextConditionRule;
use modules\main\conditions\HasEmptyCopyrightConditionRule;
use modules\main\conditions\IsCoverTitleStyleConditionRule;
use modules\main\fields\AspectRatioField;
use modules\main\fields\IncludeField;
use modules\main\fields\MarginsYField;
use modules\main\fields\OrderByField;
use modules\main\fields\SectionsField;
use modules\main\fields\ThemeColorField;
use modules\main\fields\WidthField;
use modules\main\services\ContentService;
use modules\main\twigextensions\TwigExtension;
use modules\resources\cp\CpAssets;
use yii\base\Event;
use yii\base\Module;
use function array_merge;

/**
 * Class MainModule
 *
 * @package modules\main
 *

 */
class MainModule extends Module
{

// Fields
	public static $app;

	public function init(): void
	{
		Craft::setAlias('@modules/main', $this->getBasePath());

		// Set the controllerNamespace based on whether this is a console or web request
		if (Craft::$app->getRequest()->getIsConsoleRequest()) {
			$this->controllerNamespace = 'modules\\main\\console\\controllers';
		} else {
			$this->controllerNamespace = 'modules\\main\\controllers';
		}

		// Register Services
		$this->setComponents([
			'content' => ContentService::class
		]);

		// Register Behaviors
		Event::on(
			Entry::class,
			Entry::EVENT_DEFINE_BEHAVIORS, function(DefineBehaviorsEvent $event): void {
			$event->behaviors[] = EntryBehavior::class;
		});

		// Register Rules
		Event::on(
			Entry::class,
			Entry::EVENT_DEFINE_RULES, function(DefineRulesEvent $event): void {
			$event->rules[] = ['title', 'string', 'max' => 50, 'on' => Entry::SCENARIO_LIVE];
		});

		// Register custom field types
		Event::on(
			Fields::class,
			Fields::EVENT_REGISTER_FIELD_TYPES, function(RegisterComponentTypesEvent $event): void {
			$event->types = array_merge($event->types, [
				IncludeField::class,
				WidthField::class,
				ThemeColorField::class,
				MarginsYField::class,
				SectionsField::class,
				OrderByField::class,
				AspectRatioField::class
			]);
		});

		// Register Twig extension for theme variable
		Craft::$app->view->registerTwigExtension(new TwigExtension());

		// Register CP assets
		if (Craft::$app->request->isCpRequest) {
			Event::on(
				View::class,
				View::EVENT_BEFORE_RENDER_TEMPLATE, function(): void {
				Craft::$app->view->registerAssetBundle(CpAssets::class);
			}
			);
		}

		// Validate entries on all sites (fixes open Craft bug)
		Event::on(
			Entry::class,
			Entry::EVENT_BEFORE_SAVE, function($event): void {

			if (Craft::$app->sites->getTotalSites() == 1) {
				return;
			}

			/** @var Entry $entry */
			$entry = $event->sender;

			// TODO: Check conditionals

			if ($entry->resaving || $entry->propagating || $entry->getScenario() != Entry::STATUS_LIVE) {
				return;
			}

			$entry->validate();

			if ($entry->hasErrors()) {
				return;
			}

			foreach ($entry->getLocalized()->all() as $localizedEntry) {
				$localizedEntry->scenario = Entry::SCENARIO_LIVE;

				if (!$localizedEntry->validate()) {
					$entry->addError(
						$entry->getType()->hasTitleField ? 'title' : 'slug',
						Craft::t('site', 'Error validating entry in') .
						' "' . $localizedEntry->site->name . '". ' .
						implode(' ', $localizedEntry->getErrorSummary(false)));
					$event->isValid = false;
				}
			}
		});

		// Rename images with extension 'jfif' to 'jpg'
		// see config/general.php for an explanation
		Event::on(
			Asset::class,
			Asset::EVENT_AFTER_SAVE, function(ModelEvent $event): void {
			/** @var Asset $asset */
			$asset = $event->sender;

			if ($asset->kind != 'image') {
				return;
			}

			$pathInfo = pathinfo($asset->getFilename());
			if ($pathInfo['extension'] != 'jfif') {
				return;
			}

			$newFilename = $pathInfo['filename'] . '.jpg';
			Craft::$app->assets->moveAsset($asset, $asset->getFolder(), $newFilename);
		});

		if (Craft::$app->request->isCpRequest) {
			Craft::$app->view->hook('cp.users.edit.details', function(array $context) {
				return Craft::$app->view->renderTemplate(
					'_cp/user_person.twig',
					['user' => $context['user']],
					View::TEMPLATE_MODE_SITE
				);
			});
		}

		// Don't update search index for drafts
		Event::on(
			Elements::class,
			Elements::EVENT_BEFORE_UPDATE_SEARCH_INDEX,
			function(ElementEvent $event) {
				if (ElementHelper::isDraft($event->element)) {
					$event->isValid = false;
				}
			}
		);

		Event::on(
			BaseCondition::class,
			BaseCondition::EVENT_REGISTER_CONDITION_RULE_TYPES,
			function(RegisterConditionRuleTypesEvent $event) {

				$event->conditionRuleTypes = array_merge($event->conditionRuleTypes, [
					HasEmptyCopyrightConditionRule::class,
					HasEmptyAltTextConditionRule::class,
					HasDraftsConditionRule::class,
					IsCoverTitleStyleConditionRule::class
				]);
			}
		);

		// Prevent password managers like Bitdefender Wallet from falsely inserting credentials into user form
		Craft::$app->view->hook('cp.users.edit.content', function(array &$context) {
			return '<input type="text" name="dummy-first-name" value="wtf" style="display: none">';
		});

		$this->_setElementIndexColumns();
	}

	protected function _setElementIndexColumns()
	{
		// Register element index column
		Event::on(
			Entry::class,
			Element::EVENT_REGISTER_TABLE_ATTRIBUTES, function(RegisterElementTableAttributesEvent $event) {
			$event->tableAttributes['bigFeaturedImage'] = ['label' => Craft::t('site', 'Featured Image (big)')];
		});

		Event::on(
			Entry::class,
			Element::EVENT_SET_TABLE_ATTRIBUTE_HTML, function(SetElementTableAttributeHtmlEvent $event) {

			if ($event->attribute == 'bigFeaturedImage') {
				/** @var Entry $entry */
				$entry = $event->sender;
				$event->html = 'n/a';
				$event->handled = true;

				// Don't wait for transformed images if generateTransformsBeforePageLoad = true
				$config = Craft::$app->config->general;
				$oldSetting = $config->generateTransformsBeforePageLoad;
				$config->generateTransformsBeforePageLoad = false;

				if ($entry->featuredImage) {
					$image = $entry->featuredImage->one();
					if ($image) {
						$image->setTransform(['width' => 250, 'height' => 140]);
						$event->html = Html::tag('img', '', [
							'src' => $image->url,
							'style' => 'border-radius: 3px;',
							'width' => $image->width,
							'height' => $image->height,
							'alt' => $image->alt ?? $image->title,
							'ondblclick' => "Craft.createElementEditor('craft\\\\elements\\\\Asset', {elementId: {$image->id}, siteId: {$entry->site->id}})"
						]);
					}
				}

				$config->generateTransformsBeforePageLoad = $oldSetting;
			}
		});

		Event::on(
			Entry::class,
			Entry::EVENT_PREP_QUERY_FOR_TABLE_ATTRIBUTE,
			function(ElementIndexTableAttributeEvent $event) {
				$query = $event->query;
				$attr = $event->attribute;

				if ($attr === 'bigFeaturedImage') {
					$query->andWith(
						['featuredImage', ['withTransforms' => [['width' => 200, 'height' => 120]]]]
					);
				}
			});
	}

}
