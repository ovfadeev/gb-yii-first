<?php

namespace app\commands;

use yii\console\Controller;

class RbacController extends Controller
{
  public function actionRun()
  {
    $am = \Yii::$app->authManager;

    $admin = $am->createRole('admin');
    $manager = $am->createRole('manager');
    $user = $am->createRole('user');

    $am->add($admin);
    $am->add($manager);
    $am->add($user);

    $operationCreate = $am->createPermission('createTask');
    $operationDelete = $am->createPermission('deleteTask');
    $operationUpdate = $am->createPermission('updateTask');

    $am->add($operationCreate);
    $am->add($operationDelete);
    $am->add($operationUpdate);

    $am->addChild($admin, $operationCreate);
    $am->addChild($admin, $operationDelete);
    $am->addChild($admin, $operationUpdate);

    $am->addChild($manager, $operationCreate);
    $am->addChild($manager, $operationUpdate);

    $am->addChild($user, $operationUpdate);

    $am->assign($admin, 1);
    $am->assign($manager, 2);

    $am->assign($user, 3);
    $am->assign($user, 4);
  }
}