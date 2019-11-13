<?php

namespace app\controllers;
use sizeg\jwt\Jwt;
use sizeg\jwt\JwtHttpBearerAuth;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Session;
use yii\filters\auth\HttpBasicAuth;

class SessionController extends \yii\web\Controller
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
    
    public function actionIndex()
    {
        return $this->render('index');
    }
    
     public function actionData($userId)
    {
    	$data_session = Session::checkSession($userId);
    	
    	 
        return  $data_session;
    }
    
    public function actionSetSession($userId){
    	
    	$data_session = Session::checkSession($userId);
    	
    	 if ($data_session["success"] == false){
    	 	
	    	 	$session = Yii::$app->session;
		    	$session->open();
		    	$session->set('dialio',$session->getId());
		    	$model = new Session();
		        $data['userId'] = $userId;
		        $data['data'] = $session->getId();
		        
		    	$model->attributes = $data;
    	
		
				if($session->IsActive){
					
						 if ($model->validate()){

            				try{
            					$model->save();
							}
							catch (Exception $ex)
							{
                				throw new \yii\web\HttpException(405, 'Error saving model');
                			}
                		}else{
            					$data = ['success' => false,'data' => [], 'error' => $model->getErrors()];
        					 }

				}
				
				else{
					echo "Session is not active";
				}
		} //if not records
		else{ // just update model
		
				$model = Session::findOne(['userId' => $userId]);
				$session = Yii::$app->session;
				$session->open();
				session_regenerate_id();
				$data['userId'] = $userId;
	        	$data['data'] = $session->getId();
	       		$model->attributes = $data;
	       		
			       		 if ($model->validate()){

					            try {
					            		$model->save();
					            		$data = ['successfull update' => true,'data' => $model,];
								}
					            catch (Exception $ex) {
					            		throw new \yii\web\HttpException(405, 'Error saving model');
					            		}
						}
				        else{
				        			$data = ['success' => false,'data' => [], 'error' => $model->getErrors()];
				        	}
			
			
			
		}
	
		$response = Yii::$app->response;
        $response->data = $data;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        return $response->data;
			
    			
		
	}
	
	public function actionCheckSession($userId){
		
		$session = Yii::$app->session;
		$session_data = $session->getId();
        $session_value = Session::find()
           ->select('data')
           ->where(['userId' => $userId])
           ->one();
        $old_session = Session::find()
           ->select('old_data')
           ->where(['userId' => $userId])
           ->one();
        $additional_session = Session::find()
           ->select('additional_session')
           ->where(['userId' => $userId])
           ->one();
        if($session_value){
			$data = ['success' => true,'data' => $session_value, 'old_data' => $old_session, 'additional_session' => $additional_session];
		}else{
				$data = ['success' => false,'data' => [], 'error' => $session_data . '  not such userId'];
		}
    	
        $response = Yii::$app->response;
        $response->data = $data;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        return $response->data;
        
    }
	
	public function actionKillSession(){
		
		$session = Yii::$app->session;
		$session->close();
		$session->remove('dialio');
		$session->destroy();
	}
	
	public function actionDeleteSession($userId){
	
		 Session::find()
           ->select('*')
           ->where(['userId' => $userId])
           ->one()
           ->delete();
		
		
		$data = ['success' => true];
		
		$response = Yii::$app->response;
        $response->data = $data;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        return $response->data;
		
		
	}
	public function actionUpdateSession($userId){
		$session_value = Session::find()
           ->select('*')
           ->where(['userId' => $userId])
           ->one();
		
		$data['userId'] = $userId;
		$data['old_data'] = 'not old session update';
		$data['additional_session'] = 1;
	    $session_value->attributes = $data;
	       		
   		 if ($session_value->validate()){
			
	            try {
	            		$test = $session_value->save();
	            		$data = ['success' => true,'data' => $session_value,];
				}
	            catch (Exception $ex) {
	            		throw new \yii\web\HttpException(405, 'Error saving model');
	            		}
		}
        else{
        			$data = ['success' => false,'data' => [], 'error' => $session_value->getErrors()];
        	}
			
		
		
		$response = Yii::$app->response;
        $response->data = $data;
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        return $response->data;
			
		
		
	}
	
	protected function findModel($id)
    {
        if (($model = Session::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
