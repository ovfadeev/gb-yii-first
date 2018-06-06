<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m180603_165558_create_users_table extends Migration
{
  const TABLE_NAME_USERS = 'users';
  const TABLE_NAME_ROLES = 'roles';

  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->createTable($this::TABLE_NAME_USERS, [
        'id' => $this->primaryKey(),
        'username' => $this->string(50)->notNull(),
        'password' => $this->string(100)->notNull(),
        'email' => $this->string(50)->notNull(),
        'first_name' => $this->string(50)->notNull(),
        'last_name' => $this->string(50)->notNull(),
        'role_id' => $this->integer(11)
    ]); // create table

    $this->createIndex(
        'idx-users-username',
        $this::TABLE_NAME_USERS,
        'username',
        true
    ); // unique

    $this->createIndex(
        'idx-users-email',
        $this::TABLE_NAME_USERS,
        'email',
        true
    ); // unique

    $this->addForeignKey(
        'fk-users-roles',
        $this::TABLE_NAME_USERS,
        'role_id',
        $this::TABLE_NAME_ROLES,
        'id',
        'CASCADE'
    ); // foreign key roles by id table roles
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->dropIndex(
        'idx-users-username',
        $this::TABLE_NAME_USERS
    );

    $this->dropIndex(
        'idx-users-email',
        $this::TABLE_NAME_USERS
    );

    $this->dropForeignKey(
        'fk-users-roles',
        $this::TABLE_NAME_USERS
    );

    $this->dropTable($this::TABLE_NAME);
  }
}
