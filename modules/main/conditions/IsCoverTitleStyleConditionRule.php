<?php

namespace modules\main\conditions;

use Craft;
use craft\base\conditions\BaseLightswitchConditionRule;
use craft\base\ElementInterface;
use craft\elements\conditions\ElementConditionRuleInterface;
use craft\elements\db\ElementQueryInterface;

class IsCoverTitleStyleConditionRule extends BaseLightswitchConditionRule implements ElementConditionRuleInterface
{
    public function getLabel(): string
    {
        return Craft::t('site', 'Is Cover Title Style');
    }

    public function getExclusiveQueryParams(): array
    {
        return [];
    }

    public function modifyQuery(ElementQueryInterface $query): void
    {
        // Do nothing
    }

    public function matchElement(ElementInterface $element): bool
    {
        return $this->value === false ? true : Craft::$app->config->custom->isCoverTitleStyle;
    }
}
