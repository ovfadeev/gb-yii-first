<?php

namespace app\controllers;

use app\models\events\TaskCreateEvents;
use app\models\repository\StatusTasks;
use Yii;
use app\models\repository\Tasks;
use app\models\repository\TasksSearch;
use app\models\repository\Users;
use yii\base\Event;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminTasksController implements the CRUD actions for Tasks model.
 */
class AdminTasksController extends Controller
{
  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    return [
        'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['POST'],
            ],
        ],
        [
            'class' => TimestampBehavior::class,
            'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT => ['date_create', 'date_update'],
                ActiveRecord::EVENT_BEFORE_UPDATE => ['date_update']
            ]
        ]
    ];
  }

  /**
   * Lists all Tasks models.
   * @return mixed
   */
  public function actionIndex()
  {
    $searchModel = new TasksSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single Tasks model.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionView($id)
  {
    return $this->render('view', [
        'model' => $this->findModel($id),
    ]);
  }

  /**
   * Creates a new Tasks model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate()
  {
    $model = new Tasks();

    if ($model->load(Yii::$app->request->post()) && $model->save()) {

      $model->trigger(TaskCreateEvents::EVENT_CREATE_TASK);

      $this->redirect(['view', 'id' => $model->id]);
    }

    $defStatus = StatusTasks::getDefaultStatus();

    $model->autor_id = Yii::$app->user->identity->id;
    $model->status_id = $defStatus->id;

    $users = Users::find()->all();

    return $this->render('create', [
        'model' => $model,
        'users' => $users
    ]);
  }

  /**
   * Updates an existing Tasks model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionUpdate($id)
  {
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
    }

    $model->autor_id = Yii::$app->user->identity->id;

    $status = StatusTasks::find()->all();

    $users = Users::find()->all();

    return $this->render('update', [
        'model' => $model,
        'users' => $users,
        'status' => $status
    ]);
  }

  /**
   * Deletes an existing Tasks model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id)
  {
    $this->findModel($id)->delete();

    return $this->redirect(['index']);
  }

  /**
   * Finds the Tasks model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Tasks the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Tasks::findOne($id)) !== null) {
      return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
  }
}
