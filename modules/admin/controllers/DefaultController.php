<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    return [
        'access' => [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => function($rule, $action){
                      return Yii::$app->user->can('createTask');
                    }
                ],
            ],
        ],
    ];
  }
  /**
   * Renders the index view for the module
   * @return string
   */
  public function actionIndex()
  {
    $menu = [
        [
            'name' => 'Tasks',
            'link' => Url::to(['/admin/tasks'])
        ],
        [
            'name' => 'Users',
            'link' => Url::to(['/admin/users'])
        ]
    ];

    return $this->render('index', [
        'menu' => $menu
    ]);
  }
}
