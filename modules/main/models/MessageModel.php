<?php

namespace modules\main\models;

use Craft;
use craft\base\Model;

class MessageModel extends Model
{
    public int $confirmed = 0;
    public string $emailFrom = '';
    public string $emailTo = '';
    public string $message = '';
    public string $name = '';
    public string $subject = '';

    public function attributeLabels()
    {
        return [
            'emailFrom' => Craft::t('site', 'Email'),
            'name' => Craft::t('site', 'Name'),
            'subject' => Craft::t('site', 'Subject'),
            'message' => Craft::t('site', 'Message'),
        ];
    }

    public function init(): void
    {
        $user = Craft::$app->user->identity;
        if ($user) {
            $this->name = $user->fullName;
            $this->emailFrom = $user->email;
        }
    }

    public function rules(): array
    {
        return [
            [
                ['name', 'emailFrom', 'subject', 'message'],
                'required'
            ],
            [
                'emailFrom',
                'email'
            ],
            [
                'confirmed',
                'default',
                'value' => 0
            ],
            [
                'confirmed',
                'compare',
                'compareValue' => 1,
                'operator' => '==',
                'type' => 'number',
                'message' => Craft::t('site', 'You have to confirm to proceed')
            ]
        ];
    }
}
