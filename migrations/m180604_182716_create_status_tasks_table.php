<?php

use yii\db\Migration;

/**
 * Handles the creation of table `status_tasks`.
 */
class m180604_182716_create_status_tasks_table extends Migration
{
  const TABLE_NAME_STATUS_TASKS = 'status_tasks';

  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->createTable($this::TABLE_NAME_STATUS_TASKS, [
        'id' => $this->primaryKey(),
        'title' => $this->string(50)->notNull(),
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->dropTable('status_tasks');
  }
}
