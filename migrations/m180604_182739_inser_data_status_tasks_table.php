<?php

use yii\db\Migration;

/**
 * Class m180604_182739_inser_data_status_tasks_table
 */
class m180604_182739_inser_data_status_tasks_table extends Migration
{
    const TABLE_NAME_STATUS_TASKS = 'status_tasks';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert($this::TABLE_NAME_STATUS_TASKS, [
            'title' => 'New'
        ]);

        $this->insert($this::TABLE_NAME_STATUS_TASKS, [
            'title' => 'In work'
        ]);

        $this->insert($this::TABLE_NAME_STATUS_TASKS, [
            'title' => 'Close'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return false;
    }
}
