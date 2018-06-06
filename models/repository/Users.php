<?php

namespace app\models\repository;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string username
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
        [['username', 'password', 'email', 'first_name', 'last_name', 'role_id'], 'required'],
        [['username', 'email', 'first_name', 'last_name'], 'string', 'max' => 50],
        [['password'], 'string', 'max' => 100],
        [['username'], 'unique'],
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
        'username' => 'Username',
        'password' => 'Password',
        'email' => 'Email',
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
    ];
  }

  public function beforeSave($insert)
  {
    if (parent::beforeSave($insert)) {
      if ($this->isNewRecord) {
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
      }
      return true;
    } else {
      return false;
    }
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getRole()
  {
    return $this->hasOne(Roles::className(), ['id' => 'role_id']);
  }

  public function getFullName()
  {
    return $this->first_name . ' ' . $this->last_name;
  }
}
