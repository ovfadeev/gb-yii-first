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
        return [
            'id' => 'ID',
            'name' => 'Name',
            'path' => 'Path',
            'resize_path' => 'Resize Path',
            'type' => 'Type',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
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
