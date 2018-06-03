<?php

use yii\db\Migration;

/**
 * Handles the creation of table `roles`.
 */
class m180603_165520_create_roles_table extends Migration
{
    const TABLE_NAME = 'roles';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'title' => $this->string(50)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('roles');
    }
}
