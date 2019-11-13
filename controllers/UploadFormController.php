<?php

namespace app\controllers;
use Yii;
use app\models\UploadForm;
use app\models\BackendUsers;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class UploadFormController extends \yii\web\Controller
{
	
	
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionUpload()
    {
    	
        $model = new UploadForm();
        $data = Yii::$app->request->get();
        $img64 = $data['img64'];
        
        $backendId = 3;
        if (Yii::$app->request->isPost) {
        	               
            $model->file = UploadedFile::getInstance($model, 'file');
            $imgName = $model->file->baseName . '.' . $model->file->extension;
               
            if ($model->file && $model->validate()) { 
            	$model->file->saveAs('uploads/' . $model->file->baseName . '.' . $model->file->extension);
            	$this->generateImage($img64);
                $this->updateBackendUsersProfileImage($backendId,$imgName);
            }
        }

       			return $this->render('index', ['model' => $model]);
    }
    
    public function updateBackendUsersProfileImage($backendId, $imgName)
    {
    	$model = $this->findModel($backendId);
    	$data['profile_picture'] = $imgName;
        $model->attributes = $data;
        
        //echo '<pre>';
       //print_r( $model->attributes);
        //exit;
        //echo '</pre>';
        
         if ($model->validate()){
            try {
            		$model->save();
            		$data = ['successfull update' => true,'data' => $model,];
            		//echo '<pre>';
            		//print_r($data);
            		//exit;
            		//echo '</pre>';
            		
			}
            catch (Exception $ex) {
            		throw new \yii\web\HttpException(405, 'Error saving model');
            		}
		}
        else{
        			$data = ['success' => false,'data' => [], 'error' => $model->getErrors()];
        	}
        	
        	$response = Yii::$app->response;
        	$response->data = $data;
         //\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
         
            return $response->data;
		
		
	}
	
	public function generateImage($img)

    {

        $folderPath = "uploads/";
        $image_parts = explode(";base64,", $img);
        //print_r($image_parts);
        
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        $file = $folderPath . uniqid() . '.png';

		file_put_contents($file, $image_base64);

    }
	
	 protected function findModel($id)
    {
        if (($model = BackendUsers::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
