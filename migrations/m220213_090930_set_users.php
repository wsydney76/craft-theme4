<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;
use craft\elements\User;
use craft\helpers\App;
use craft\helpers\Assets;
use Faker\Factory;
use function array_diff;
use function copy;
use function pathinfo;
use function scandir;
use const DIRECTORY_SEPARATOR;

/**
 * m220213_090930_userphotos migration.
 */
class m220213_090930_set_users extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $faker = Factory::create();

        // Set admin attributes
        $user = User::find()->one();
        $user->firstName = 'Sabine';
        $user->lastName = 'Mustermann';
        $user->email = $faker->email();
        $user->telephone = $faker->phoneNumber();
        $user->teaser = 'Editor in Chief';

        Craft::$app->elements->saveElement($user);


        // Add new user
        $user = new User();
        $user->username = 'erna';
        $user->email = 'erna@klawuppke.com';
        $user->firstName = 'Erna';
        $user->lastName = 'Klawuppke';
        $user->telephone = $faker->phoneNumber();
        $user->teaser = 'Editor';

        $user->scenario = User::SCENARIO_LIVE;

        if (Craft::$app->elements->saveElement($user)) {
            $group = Craft::$app->userGroups->getGroupByHandle('editors');

            if ($group) {
                Craft::$app->users->assignUserToGroups($user->id, [$group->id]);
            }
        }

        // Set user photos
        $sourceDir = App::parseEnv('@storage/rebrand/userphotos');

        $files = scandir($sourceDir);
        $files = array_diff($files, ['.', '..']);

        foreach ($files as $file) {
            $path = $sourceDir . DIRECTORY_SEPARATOR . $file;
            $pathInfo = pathinfo($path);
            $username = $pathInfo['filename'];

            $user = User::find()->username($username)->one();
            if ($user) {
                // saveUserPhoto deletes the file, so making a temporary copy
                $tempPath = Assets::tempFilePath($pathInfo['extension']);
                copy($path, $tempPath);
                Craft::$app->users->saveUserPhoto($tempPath, $user);
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
