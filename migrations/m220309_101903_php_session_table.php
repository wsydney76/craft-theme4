<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;
use craft\db\Table;
use craft\migrations\CreatePhpSessionTable;

/**
 * m220309_101903_php_session_table migration.
 */
class m220309_101903_php_session_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTableIfExists(Table::SESSIONS);
        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        if (Craft::$app->getDb()->tableExists(Table::PHPSESSIONS)) {
            return true;
        }

        $migration = new CreatePhpSessionTable();
        return $migration->up() !== false;
    }
}
