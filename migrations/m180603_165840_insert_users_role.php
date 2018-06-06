<?php

use yii\db\Migration;

/**
 * Class m180603_165840_insert_users_role
 */
class m180603_165840_insert_users_role extends Migration
{
  const TABLE_NAME_USERS = 'users';
  const TABLE_NAME_ROLES = 'roles';

  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    // table roles
    $this->insert($this::TABLE_NAME_ROLES, [
        'title' => 'admin'
    ]);

    $this->insert($this::TABLE_NAME_ROLES, [
        'title' => 'managers'
    ]);

    $this->insert($this::TABLE_NAME_ROLES, [
        'title' => 'developers'
    ]);

    // table users add admin
    $this->insert($this::TABLE_NAME_USERS, [
        'username' => 'admin',
        'password' => Yii::$app->getSecurity()->generatePasswordHash('admin'),
    'email' => 'webmaster@site.ru',
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'role_id' => 1
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
