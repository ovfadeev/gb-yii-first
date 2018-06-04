<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tasks`.
 */
class m180604_174710_create_tasks_table extends Migration
{
    const TABLE_NAME_USERS = 'users';
    const TABLE_NAME_TASKS = 'tasks';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this::TABLE_NAME_TASKS, [
            'id' => $this->primaryKey(),
            'name' => $this->stirng(150)->notNull(),
            'date_create' => $this->timestamp()->defaultValue(['expression'=>'CURRENT_TIMESTAMP']),
            'date_update' => $this->timestamp()->defaultValue(['expression'=>'ON UPDATE CURRENT_TIMESTAMP']),
            'autor_id' => $this->integer(11),
            'performer_id' => $this->integer(11),
            'description' => $this->text()
        ]);

        $this->addForeignKey(
            'fk-tasks-autor-users',
            $this::TABLE_NAME_TASKS,
            'autor_id',
            $this::TABLE_NAME_USERS,
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-tasks-performer-users',
            $this::TABLE_NAME_TASKS,
            'performer_id',
            $this::TABLE_NAME_USERS,
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this::TABLE_NAME_TASKS);
    }
}
