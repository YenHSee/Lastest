<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\filters\auth\QueryParamAuth;
use app\models\User;
use app\models\SignupForm;
use app\models\UpdateForm;
use app\controllers\apicontroller\ApiController;

class TestController extends ApiController
{
	public $enableCsrfValidation = false;
//	$_SERVER[PHP_AUTH_*]

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),[
            'authenticator'=> [
                'class' => QueryParamAuth::className(),
                'except' => ['call-api', 'signup', 'update'],
                ]
            ]);
    }

    public function actionCallApi()
    {
        $model = User::find();
        $resp = [];

        foreach($model->each() as $m){
            $resp[$m->name] = $m->name;
            $resp[$m->username] = $m->username;
            // $resp["this is name"] = $m->username;
        }

        return $resp;
    }

    // public function actions()
    // {
    // 	$actions = parent::actions();
    // 	unset($actions['create']);
    // 	return $actions;
    // }

    // public function actionCreateUser()
    // {
    // 	$user = new User();
    // 	$user->scenario = User::SCENARIO_CREATE;
    // 	$user->username = \Yii::$app->request->post();

    // 	if ($user->validate())
    // 	{
    // 		return array('status' => true);
    // 	}
    // 	else
    // 	{
    // 		return array('status' => false, 'data'=>$user->getErrors());
    // 	}
    // }
    public function actionSignup()
    {
    	$model = new SignupForm();
        if ($model->load(Yii::$app->request->post(), '')) {
            if ($model->signup()) {
                return array('status' => true);
            }
            else {
                throw new Exception(current($model->getFirstErrors()));
            }
        }  
    }

    public function actionUpdate($id)
    {
        $model = new UpdateForm();
        if ($model->load(Yii::$app->request->post(), '')) {
            if ($model->update($id)) {
                return array('status' => true);
            }
            else {
                    throw new Exception(current($model->getFirstErrors()));
            }
        }        
    }

}