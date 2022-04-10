<?php

namespace modules\main\services;

use Craft;
use craft\base\Component;
use craft\elements\Entry;
use craft\elements\GlobalSet;
use craft\elements\User;
use craft\helpers\Json;
use craft\helpers\StringHelper;
use modules\main\models\MessageModel;

class ContentService extends Component
{
    public function sendMessage(MessageModel $message, ?int $id): bool
    {
        if ($id) {
            $recipient = Entry::find()->id($id)->one();
            if ($recipient) {
                $message->emailTo = $recipient->email ?? $recipient->author->email;
            }
        }

        if (!$message->emailTo) {
            $siteInfo = GlobalSet::find()->handle('siteInfo')->one();
            $message->emailTo = $siteInfo->email;
        }

        $this->saveMessage($message);

        $sent = Craft::$app->mailer->compose()
            ->setFrom([$message->emailFrom => $message->name])
            ->setTo($message->emailTo)
            ->setSubject($message->subject)
            ->setTextBody($message->message)
            ->send();

        if (!$sent) {
            return false;
        }

        return true;
    }

    protected function saveMessage(MessageModel $message): void
    {
        $section = Craft::$app->sections->getSectionByHandle('contactMessage');
        $type = $section->getEntryTypes()[0];
        $site = Craft::$app->sites->getSiteByHandle('de');
        $user = User::find()->admin(1)->one();

        $title = $message->name . ': ' . $message->subject;

        $entry = new Entry([
            'sectionId' => $section->id,
            'typeId' => $type->id,
            'siteId' => $site->id,
            'authorId' => $user->id,
            'title' => $title,
            'slug' => StringHelper::slugify($title),
            'snapshot' => Json::encode($message->getAttributes())
        ]);

        Craft::$app->elements->saveElement($entry);
    }
}
