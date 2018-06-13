<?php

namespace app\models\repository;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property string $text
 * @property int $autor_id
 * @property int $file_id
 * @property string $date_create
 * @property string $date_update
 *
 * @property Users $autor
 * @property Files $file
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'autor_id'], 'required'],
            [['text'], 'string'],
            [['autor_id', 'file_id'], 'integer'],
            [['date_create', 'date_update'], 'safe'],
            [['autor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['autor_id' => 'id']],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => Files::className(), 'targetAttribute' => ['file_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'autor_id' => 'Autor ID',
            'file_id' => 'File ID',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
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
    public function getFile()
    {
        return $this->hasOne(Files::className(), ['id' => 'file_id']);
    }
}
