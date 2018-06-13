<?php

namespace app\models;

use Yii;
use app\models\repository\Files;
use yii\base\Model;
use yii\imagine\Image;

class File extends Model
{
  public $file;
  public $name;
  public $path;
  public $resize_path;
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

  protected static function createDir($path)
  {
    return (is_dir($path) || mkdir($path, 0644, true));
  }

  public function getPath($id)
  {
    $model = Files::find()->where(["id" => $id])->one();
    return $model->path . $model->name;
  }

  public function uploadFile()
  {
    $this->name = $this->file->getBaseName() . "." . $this->file->getExtension();

    $this->type = $this->file->type;

    if ($this->isImage()){
      $this->path = \Yii::$app->params['dir_upload']['images']['original'];
      $this->resize_path = \Yii::$app->params['dir_upload']['images']['resize'];
    } else {
      $this->path = \Yii::$app->params['dir_upload']['all'];
    }

    $savePath = \Yii::getAlias('@webroot' . $this->path);

    if (self::createDir($savePath)) {
      $this->file->saveAs($savePath . $this->name);
    }
  }

  public function resizeImage($width, $height)
  {
    $savePath = \Yii::getAlias('@webroot' . $this->resize_path);
    if (self::createDir($savePath)) {
      Image::thumbnail(\Yii::getAlias('@webroot' . $this->path) . $this->name, $width, $height)
          ->save($savePath . $this->name, ['quality' => $quality]);
    }
  }

  public function isImage()
  {
    switch ($this->type) {
      case 'image/jpeg':
        return true;
        break;

      default:
        return false;
        break;
    }
  }
}