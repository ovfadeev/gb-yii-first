<?php

namespace app\models\repository;

use Yii;

/**
 * This is the model class for table "status_tasks".
 *
 * @property int $id
 * @property string $title
 *
 * @property Tasks[] $tasks
 */
class StatusTasks extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'status_tasks';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
        [['title'], 'required'],
        [['title'], 'string', 'max' => 50],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
        'id' => 'ID',
        'title' => 'Title',
    ];
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getTasks()
  {
    return $this->hasMany(Tasks::className(), ['status_id' => 'id']);
  }

  public static function getDefaultStatus()
  {
    return static::find(['order'=>'id'])->one();
  }
}
