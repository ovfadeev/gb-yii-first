<?php

namespace app\models\repository;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

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
    $langFile = 'app_tasks';
    return [
        'id' => Yii::t($langFile, 'attribute_id'),
        'name' => Yii::t($langFile, 'attribute_name'),
        'date_create' => Yii::t($langFile, 'attribute_date_create'),
        'date_update' => Yii::t($langFile, 'attribute_date_update'),
        'deadline' => Yii::t($langFile, 'attribute_deadline'),
        'description' => Yii::t($langFile, 'attribute_descroption'),
        'autor_id' => Yii::t($langFile, 'attribute_autor_id'),
        'performer_id' => Yii::t($langFile, 'attribute_performer_id'),
        'status_id' => Yii::t($langFile, 'attribute_status_id'),
    ];
  }

  public function behaviors()
  {
    return [
        [
            'class' => TimestampBehavior::className(),
            'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT => ['date_create', 'date_update'],
                ActiveRecord::EVENT_BEFORE_UPDATE => ['date_update'],
            ],
            'value' => new Expression('NOW()'),
        ],
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

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getComments()
  {
    return $this->hasOne(Comments::className(), ['task_id' => 'id']);
  }

  public static function getTasksDeadlineOnDays($idUser, $nDay, $nMonth, $nYear)
  {
    return self::find()
        ->where([
            'performer_id' => $idUser
        ])
        ->andWhere([
            'YEAR(deadline)' => $nYear
        ])
        ->andWhere([
            'MONTH(deadline)' => $nMonth
        ])
        ->andWhere([
            'DAY(deadline)' => $nDay
        ]);
  }

  public static function getTasksDeadlineExpiring()
  {
    return self::find()
        ->where([
            '<=',
            'deadline',
            date('Y-m-d H:i:s')
        ])
        ->andWhere([
            '<>',
            'status_id',
            StatusTasks::find()->where(['title' => 'Close'])->one()->id
        ])
        ->all();
  }

}
