<?php

use yii\db\Migration;

/**
 * Handles the creation of table `files`.
 */
class m180611_183120_create_files_table extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->createTable('files', [
        'id' => $this->primaryKey(),
        'path' => $this->string(150)->notNull(),
        'date_create' => 'DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL',
        'date_update' => 'DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL',
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->dropTable('files');
  }
}
