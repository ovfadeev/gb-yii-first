<?php

namespace app\models\repository;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $name
 * @property string $date_create
 * @property string $date_update
 * @property string $deadline
 * @property string $description
 * @property int $autor_id
 * @property int $performer_id
 * @property int $status_id
 *
 * @property Users $autor
 * @property Users $performer
 * @property StatusTasks $status
 */
class Tasks extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'tasks';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
        [['name', 'description', 'autor_id', 'performer_id'], 'required'],
        [['date_create', 'date_update', 'deadline'], 'safe'],
        [['description'], 'string'],
        [['autor_id', 'performer_id', 'status_id'], 'integer'],
        [['name'], 'string', 'max' => 150],
        [['autor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['autor_id' => 'id']],
        [['performer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['performer_id' => 'id']],
        [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusTasks::className(), 'targetAttribute' => ['status_id' => 'id']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
        'id' => 'ID',
        'name' => 'Name',
        'date_create' => 'Date Create',
        'date_update' => 'Date Update',
        'deadline' => 'Deadline',
        'description' => 'Description',
        'autor_id' => 'Autor ID',
        'performer_id' => 'Performer ID',
        'status_id' => 'Status ID',
    ];
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getAutor()
  {
    return $this->hasOne(Users::className(), ['id' => 'autor_id']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getPerformer()
  {
    return $this->hasOne(Users::className(), ['id' => 'performer_id']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getStatus()
  {
    return $this->hasOne(StatusTasks::className(), ['id' => 'status_id']);
  }
}
