<?php

namespace app\models\repository;

use Yii;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property string $name
 * @property string $path
 * @property string $resize_path
 * @property string $type
 * @property string $date_create
 * @property string $date_update
 *
 * @property Comments[] $comments
 */
class Files extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'files';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
        [['name', 'path', 'type'], 'required'],
        [['date_create', 'date_update'], 'safe'],
        [['name', 'path', 'resize_path', 'type'], 'string', 'max' => 255],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    $langFile = 'app_files';
    return [
        'id' => Yii::t($langFile, 'attribute_id'),
        'name' => Yii::t($langFile, 'attribute_name'),
        'path' => Yii::t($langFile, 'attribute_path'),
        'resize_path' => Yii::t($langFile, 'attribute_resize_path'),
        'type' => Yii::t($langFile, 'attribute_type'),
        'date_create' => Yii::t($langFile, 'attribute_date_create'),
        'date_update' => Yii::t($langFile, 'attribute_date_update'),
    ];
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getComments()
  {
    return $this->hasMany(Comments::className(), ['file_id' => 'id']);
  }
}
