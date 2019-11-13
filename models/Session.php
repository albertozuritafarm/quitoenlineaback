<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "session".
 *
 * @property int $id
 * @property int $userId
 * @property resource $data
 * @property string $time_created
 * @property string $time_updated
 */
class Session extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'session';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'data', 'old_data', 'additional_session'], 'required'],
            [['userId'], 'integer'],
            [['data'], 'string'],
            [['old_data'], 'string'],
            [['additional_session'], 'boolean'],
            [['time_created', 'time_updated'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'data' => 'Data',
            'old_data' => 'Old Data',
            'time_created' => 'Time Created',
            'time_updated' => 'Time Updated',
            'additional_session' => 'Additional Session',
        ];
    }
    
    public function checkSession($userId){
		
		$session = Yii::$app->session;
		$session_data = $session->getId();
        $session_value = Session::find()
           ->select('data')
           ->where(['userId' => $userId])
           ->one();
        if($session_value !=NULL){
			$data = ['success' => true,'sessionId' => $session_value];
		}else{
				$data = ['success' => false];
		}
    	
        $response = Yii::$app->response;
        $response->data = $data;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        return $response->data;
        
    }
    
    public function killSession(){
		
		$session = Yii::$app->session;
		$session->close();
		$session->remove('dialio');
		$session->destroy();
	}
	
	public function setSession($userId){
		
    	$data_session = $this->checkSession($userId);
    	if($data_session['success'] ==true){
    		$old_session = $data_session['sessionId']['data'];
		}else if ($data_session['success']==false){
			$old_session = 'not old session';
		}
    	
    	
    	 if ($data_session["success"] == false){
    	 	    
	    	 	$session = Yii::$app->session;
		    	$session->open();
		    	session_regenerate_id();
		    	$session->set('dialio',$session->getId());
		    	$model = new Session();
		    	$data['userId'] = $userId;
		        $data['data'] = $session->getId();
		        $data['old_data'] = $old_session;
		       
		        $date = new \DateTime();
		        $date->format('U = Y-m-d H:i:s');
		    	$data['time_created'] = $date->format('U = Y-m-d H:i:s');
		        $data['time_updated'] = $date->format('U = Y-m-d H:i:s');
		        $data['additional_session'] = false;
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
		
				$model = $this->findOne(['userId' => $userId]);
				$session = Yii::$app->session;
				$session->open();
				session_regenerate_id();
				$data['userId'] = $userId;
	        	$data['data'] = $session->getId();
	        	$old_session = $data_session['sessionId']['data'];
	        	$data['old_data'] = $old_session;
	        	$date = new \DateTime();
	        	$data['time_created'] = $date->format('U = Y-m-d H:i:s');
	       		$data['time_updated'] = $date->format('U = Y-m-d H:i:s');
	       		$data['additional_session'] = true;
	       		
	       		$model->attributes = $data;
	       		
			       		 if ($model->validate()){

					            try {
					            		$model->save();
					            		$data = ['success' => true,'data' => $model,];
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
	
	protected function findModel($userId)
    {
        if (($model = Session::findOne($userId)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
