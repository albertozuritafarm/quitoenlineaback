<?php

namespace app\controllers;

use sizeg\jwt\Jwt;
use sizeg\jwt\JwtHttpBearerAuth;
use Yii;
use yii\rest\Controller;
use app\models\BackendUsers;
use yii\filters\auth\HttpBasicAuth;

class BackendUsersController extends \yii\web\Controller
{


	public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];
        
        $behaviors['authenticator'] = [
            'class' => JwtHttpBearerAuth::class,
            'optional' => [
                'login',
            ],
        ];

        return $behaviors;
    }

    public function beforeAction($action)
    {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }


    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGetUserInformation()
    {
    	$get = Yii::$app->request->get();
        $userId = $get['userId'];
        $this->actionGetUserInformationByUserId($userId);
    }

    public function actionGetUserInformationByUserId($userId)
    {
    	$user = BackendUsers::findOne(['id' => $userId]);

    	unset($user['password'],$user['authKey'],$user['pasword_reset_token']);

        $data = ['success' => true,'data' => $user];

        $response = Yii::$app->response;
        $response->data = $data;
        
        return $response->data;	
    }

    public function actionUpdateUserInformation()
    {
    	$get = Yii::$app->request->get();
        $this->actionUpdateUserInformationByUserId($get);
    }


    public function actionUpdateUserInformationByUserId($newInfo)
    {

    	$user =  BackendUsers::findOne(['id' => $newInfo['userId']]);
        $user->name = $newInfo['name'];
        $user->username = $newInfo['username'];
        $user->email = $newInfo['email'];
        $user->cellphone = $newInfo['cellphone'];

        if ($user->validate()){

            try 
	        {
	            $user->save();
	            unset($user['password'],$user['authKey'],$user['pasword_reset_token']);
	            $data = ['success' => true,'data' => $user,];
	        } 
	        catch (Exception $ex) 
	        {
	            throw new \yii\web\HttpException(405, 'Error saving model');
	        }

        }else{
            $data = ['success' => false,'data' => [], 'error' => $user->getErrors()];
        }


        $response = Yii::$app->response;
        $response->data = $data;
        
        return $response->data;
    }

}
