<?php

namespace modules\main\behaviors;

use craft\elements\Entry;
use yii\base\Behavior;

/**
 *
 * @property array $externalImages
 */
class EntryBehavior extends Behavior
{

    public function events()
    {
        return [
            Entry::EVENT_BEFORE_VALIDATE => '_validate'
        ];
    }

    public function _validate()
    {
        /** @var Entry $entry */
        $entry = $this->owner;

        if ($entry->getScenario() != Entry::SCENARIO_LIVE) {
            return;
        }
    }

    public function getNavTitle()
    {
        /** @var Entry $entry */
        $entry = $this->owner;

        return $entry->alternativeTitle ?? $entry->title;
    }
}
