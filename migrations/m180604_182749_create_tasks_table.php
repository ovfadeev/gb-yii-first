<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tasks`.
 */
class m180604_182749_create_tasks_table extends Migration
{
    const TABLE_NAME_USERS = 'users';
    const TABLE_NAME_TASKS = 'tasks';
    const TABLE_NAME_STATUS_TASKS = 'status_tasks';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this::TABLE_NAME_TASKS, [
            'id' => $this->primaryKey(),
            'name' => $this->string(150)->notNull(),
            'date_create' => 'DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL',
            'date_update' => 'DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL',
            'deadline' => $this->dateTime(),
            'description' => $this->text()->notNull(),
            'autor_id' => $this->integer(11)->notNull(),
            'performer_id' => $this->integer(11)->notNull(),
            'status_id' => $this->integer(11)->notNull()->defaultValue(1),
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

        $this->addForeignKey(
            'fk-tasks-status-id',
            $this::TABLE_NAME_TASKS,
            'status_id',
            $this::TABLE_NAME_STATUS_TASKS,
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-tasks-autor-users',
            $this::TABLE_NAME_TASKS
        );

        $this->dropIndex(
            'fk-tasks-performer-users',
            $this::TABLE_NAME_TASKS
        );

        $this->dropIndex(
            'fk-tasks-status-id',
            $this::TABLE_NAME_TASKS
        );

        $this->dropTable($this::TABLE_NAME_TASKS);
    }
}
