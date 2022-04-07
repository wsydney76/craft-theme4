<?php

namespace modules\main\models;

use Craft;
use craft\base\Model;

class MessageModel extends Model
{
    public string $name = '';
    public string $email = '';
    public string $subject = '';
    public string $message = '';

    public function init() {
        $user = Craft::$app->user->identity;
        if ($user) {
            $this->name = $user->fullName;
            $this->email = $user->email;
        }
    }

    public function rules(): array
    {
        return [
            [['name','email','subject','message'], 'required'],
            ['email', 'email']
        ];

    }

    public function attributeLabels()
    {
        return [
            'email' => Craft::t('site', 'Email'),
            'name' => Craft::t('site', 'Name'),
            'subject' => Craft::t('site', 'Subject'),
            'message' => Craft::t('site', 'Message'),
        ];
    }
}
