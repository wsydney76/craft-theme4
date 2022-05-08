<?php

namespace modules\main\services;

use Craft;
use craft\base\Component;
use craft\elements\Entry;
use craft\elements\GlobalSet;
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

        return Craft::$app->mailer->compose()
            ->setFrom([$message->emailFrom => $message->name])
            ->setTo($message->emailTo)
            ->setSubject($message->subject)
            ->setTextBody($message->message)
            ->send();
    }

}
