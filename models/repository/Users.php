<?php

namespace app\models\repository;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 */
class Users extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'users';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
        [['login', 'password', 'email', 'first_name', 'last_name'], 'required'],
        [['login', 'email', 'first_name', 'last_name'], 'string', 'max' => 50],
        [['password'], 'string', 'max' => 100],
        [['login'], 'unique'],
        [['email'], 'unique'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
        'id' => 'ID',
        'login' => 'Login',
        'password' => 'Password',
        'email' => 'Email',
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
    ];
  }
}
