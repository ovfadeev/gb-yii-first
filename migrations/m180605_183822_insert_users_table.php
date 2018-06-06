<?php

use yii\db\Migration;

/**
 * Class m180605_183822_insert_users_table
 */
class m180605_183822_insert_users_table extends Migration
{
  const TABLE_NAME_USERS = 'users';

  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->insert($this::TABLE_NAME_USERS, [
        'username' => 'manager',
        'password' => Yii::$app->getSecurity()->generatePasswordHash('manager'),
        'email' => 'manager@site.ru',
        'first_name' => 'manager',
        'last_name' => 'manager',
        'role_id' => 2
    ]);
    $this->insert($this::TABLE_NAME_USERS, [
        'username' => 'dev1',
        'password' => Yii::$app->getSecurity()->generatePasswordHash('dev1'),
        'email' => 'dev1@site.ru',
        'first_name' => 'dev1',
        'last_name' => 'dev1',
        'role_id' => 3
    ]);
    $this->insert($this::TABLE_NAME_USERS, [
        'username' => 'dev2',
        'password' => Yii::$app->getSecurity()->generatePasswordHash('dev2'),
        'email' => 'dev2@site.ru',
        'first_name' => 'dev2',
        'last_name' => 'dev2',
        'role_id' => 3
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
