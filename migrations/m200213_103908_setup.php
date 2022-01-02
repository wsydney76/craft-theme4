<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;
use craft\elements\GlobalSet;
use craft\elements\User;

/**
 * m200213_103908_setup migration.
 */
class m200213_103908_setup extends Migration
{

    /**
     * @return bool|void
     * @throws \Throwable
     * @throws \craft\errors\ElementNotFoundException
     * @throws \yii\base\Exception
     */
    public function safeUp()
    {

        // Set Globals
        $global = GlobalSet::find()->handle('siteInfo')->one();
        if ($global) {
            $global->setFieldValue('siteName', 'Starter');
            $global->setFieldValue('copyright', 'Starter GmbH');
            $global->setFieldValue('cookieConsentText', 'Wir verwenden manchmal Cookies');
            $global->setFieldValue('cookieConsentInfo', 'Siehe Datenschutzerklärung');
            Craft::$app->elements->saveElement($global);
        }

        // Set user full name
        $user = User::find()->one();
        $user->firstName = 'Sabine';
        $user->lastName = 'Mustermann';
        $user->email = 'chef@example.com';
        $user->teaser = 'Editor in Chief';

        Craft::$app->elements->saveElement($user);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "There is nothing to revert.\n";
        return true;
    }
}
