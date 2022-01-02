<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;
use craft\elements\User;

/**
 * m210216_101210_add_user migration.
 */
class m210216_101210_add_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $user = new User();
        $user->username = 'erna';
        $user->email = 'erna@klawuppke.com';
        $user->firstName = 'Erna';
        $user->lastName = 'Klawuppke';

        $user->scenario = User::SCENARIO_LIVE;

        if (Craft::$app->elements->saveElement($user)) {
            $group = Craft::$app->userGroups->getGroupByHandle('editors');

            if ($group) {
                Craft::$app->users->assignUserToGroups($user->id, [$group->id]);
            }
        }
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
