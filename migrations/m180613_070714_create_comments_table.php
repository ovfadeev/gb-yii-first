<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comments`.
 */
class m180613_070714_create_comments_table extends Migration
{
  const TABLE_NAME_USERS = 'users';
  const TABLE_NAME_COMMENTS = 'comments';
  const TABLE_NAME_FILES = 'files';

  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->createTable($this::TABLE_NAME_COMMENTS, [
        'id' => $this->primaryKey(),
        'text' => $this->text()->notNull(),
        'autor_id' => $this->integer(11)->notNull(),
        'file_id' => $this->integer(11)->notNull(),
        'date_create' => 'DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL',
        'date_update' => 'DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL',
    ]);

    $this->addForeignKey(
        'fk-comments-autor-user',
        $this::TABLE_NAME_COMMENTS,
        'autor_id',
        $this::TABLE_NAME_USERS,
        'id',
        'CASCADE'
    );

    $this->addForeignKey(
        'fk-comments-files',
        $this::TABLE_NAME_COMMENTS,
        'file_id',
        $this::TABLE_NAME_FILES,
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
        'fk-comments-autor-user',
        $this::TABLE_NAME_COMMENTS
    );

    $this->dropForeignKey(
        'fk-comments-files',
        $this::TABLE_NAME_COMMENTS
    );

    $this->dropTable('comments');
  }
}
