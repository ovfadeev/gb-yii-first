<?php

namespace app\models;

use app\models\repository\Files;
use yii\base\Model;

class File extends Model
{
  public $file;
  public $title;
  public $path;
  public $type;

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
        ['file', 'file'],
    ];
  }

  public function uploadFile()
  {
    $this->title = $this->file->getBaseName() . "." . $this->file->getExtension();

    $this->type = $this->file->type;

    switch ($this->type) {
      case 'image/jpeg':
        $subdir = '/images/';
        break;

      default:
        $subdir = '/';
        break;
    }

    $this->path = \Yii::$app->params['dir_upload'] . $subdir;

    $savePath = \Yii::getAlias('@webroot' . $this->path);

    if (is_dir($savePath) || mkdir($savePath)) {
      $this->file->saveAs($savePath . $this->title);
    }
  }

  public function getPath($id)
  {
    $model = Files::find()->where(["id" => $id])->one();
    return $model->path . $model->title;
  }
}