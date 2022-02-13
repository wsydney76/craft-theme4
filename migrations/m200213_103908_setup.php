<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;
use craft\elements\Entry;
use craft\elements\GlobalSet;
use Faker\Factory;

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

        $faker = Factory::create();

        // Give the homepage some content
        $entry = Entry::find()->section('homepage')->one();

        $paragraphs = '';
        foreach ($faker->paragraphs($faker->numberBetween(3, 6)) as $paragraph) {
            $paragraphs .= '<p>' . $paragraph . '</p>';
        }

        $entry->setFieldValue('bodyContent', [
            'sortOrder' => ['new1','new2','new3','new4'],
            'blocks' => [
                'new1' => [
                    'type' => 'summary',
                    'fields' => [
                        'heading' => 'Dies ist automatisch generierter Inhalt',
                        'text' => $faker->paragraphs($faker->numberBetween(2, 3), true)
                    ]
                ],
                'new2' => [
                    'type' => 'text',
                    'fields' => [
                        'text' => $paragraphs
                    ]
                ],
                'new3' => [
                    'type' => 'heading',
                    'fields' => [
                        'heading' => 'Neue Artikel'
                    ]
                ],
                'new4' => [
                    'type' => 'dynamicBlock',
                    'fields' => [
                        'template' => 'cards.twig',
                        'parameter' => '{"section":"article","limit":3}'
                    ]
                ]
            ]
        ]);

        if (!Craft::$app->elements->saveElement($entry)) {
            echo "Error saving homepage entry\n";
        }

        // Set Globals
        $global = GlobalSet::find()->handle('siteInfo')->one();
        if ($global) {
            $global->setFieldValue('siteName', 'Starter');
            $global->setFieldValue('copyright', 'Starter GmbH');
            $global->setFieldValue('cookieConsentText', 'Wir verwenden manchmal Cookies');
            $global->setFieldValue('cookieConsentInfo', $faker->paragraphs($faker->numberBetween(2, 5), true));
            $global->setFieldValue('individualContact', $faker->paragraphs($faker->numberBetween(2, 3), true));
            $global->setFieldValue('eMail', $faker->email());
            $global->setFieldValue('telephone', $faker->phoneNumber());
            $global->setFieldValue('fax', $faker->phoneNumber());
            Craft::$app->elements->saveElement($global);
        }

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
