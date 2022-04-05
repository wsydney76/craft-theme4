<?php

namespace modules\main\behaviors;

use Craft;
use craft\base\Element;
use craft\elements\Entry;
use craft\helpers\Template;
use Twig\Markup;
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

    public function getAuthorPersonUrl(): string
    {
       $person = $this->getAuthorPerson();

        return $person ? $person->url : '';
    }

    public function getAuthorPersonLink(): string|Markup
    {
        $person = $this->getAuthorPerson();

        if (!$person) {
            /** @var Entry $entry */
            $entry = $this->owner;
            return $entry->author->fullName;
        }

        return Template::raw($person->link);
    }

    protected function getAuthorPerson(): Entry|null
    {
        /** @var Entry $entry */
        $entry = $this->owner;

        return Entry::find()
            ->section('person')
            ->relatedTo($entry->author)
            ->one();
    }
}
