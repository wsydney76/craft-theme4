<?php

namespace modules\main\behaviors;

use craft\base\Element;
use craft\elements\Entry;
use yii\base\Behavior;
use yii\base\Model;

/**
 *
 * @property array $externalImages
 */
class EntryBehavior extends Behavior
{

    /**
     * @return array<string, string>
     */
    public function events(): array
    {
        return [
            Model::EVENT_BEFORE_VALIDATE => '_validate'
        ];
    }

    public function _validate(): void
    {
        /** @var Entry $entry */
        $entry = $this->owner;

        if ($entry->getScenario() != Element::SCENARIO_LIVE) {
            return;
        }
    }

    public function getNavTitle(): ?string
    {
        /** @var Entry $entry */
        $entry = $this->owner;

        return $entry->alternativeTitle ?? $entry->title;
    }
}
