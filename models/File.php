<?php

namespace app\models;

use Yii;
use app\models\repository\Files;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use yii\base\Model;
use yii\imagine\Image;

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

  protected static function createDir($path)
  {
    return (is_dir($path) || mkdir($path, 0644,true));
  }

  public function uploadFile()
  {
    $this->title = $this->file->getBaseName() . "." . $this->file->getExtension();

    $this->type = $this->file->type;

    switch ($this->type) {
      case 'image/jpeg':
        $this->path = \Yii::$app->params['dir_upload']['images']['original'];
        break;

      default:
        $this->path = \Yii::$app->params['dir_upload']['all'];
        break;
    }

    $savePath = \Yii::getAlias('@webroot' . $this->path);

    if (self::createDir($savePath)) {
      $this->file->saveAs($savePath . $this->title);
    }
  }

  public function getPath($id)
  {
    $model = Files::find()->where(["id" => $id])->one();
    return $model->path . $model->title;
  }

  public static function resizeImage($file, $width, $height, $quality)
  {
    $originalPath = Yii::getAlias('@webroot' . $file->path);

    $resizePath = Yii::getAlias('@webroot' . Yii::$app->params['dir_upload']['images']['resize']);

    if (self::createDir($resizePath)){
      Image::thumbnail($originalPath . $file->title, $width, $height)
          ->save($resizePath . $file->title, ['quality' => $quality]);

      $file->resize = Yii::$app->params['dir_upload']['images']['resize'];
    }

    return $file;
  }
}