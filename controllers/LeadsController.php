<?php

namespace app\controllers;

use Yii;
use app\models\Leads;
use app\models\LeadsPhoneNumbers;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LeadsController implements the CRUD actions for Leads model.
 */
class LeadsController extends Controller
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
                    'AddPhoneNumberFromPane' => ['POST'],
                    
                ],
            ],

             'corsFilter' => [
                    'class' => \yii\filters\Cors::className(),
                ],
        
        ];
    }

    public function beforeAction($action)
    {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }


    public function actions()
    {
        $actions = parent::actions();

        // customize the data provider preparation with the "prepareDataProvider()" method
        //$actions['index']['actionAddPhoneNumberFromPane'] = [$this, 'actionAddPhoneNumberFromPane'];

        return $actions;
    }



    /**
     * Lists all Leads models.
     * @return mixed
     */
    public function actionIndex()
    {

        $leads = Leads::find()->all();
        $data = ['success' => true,'data' => $leads];
        
        $response = Yii::$app->response;
        $response->data = $data;
        
        return $response->data;
    }

    /**
     * Displays a single Leads model.
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
     * Creates a new Leads model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     public function actionCreate()
    {
        $model = new Leads();
        
        //Load parameters data
        $data = Yii::$app->request->get();
        $phone_number = $data['phone_number'];
       
        //Set model attribute
        $model->attributes = $data;
        $name = 'Primary';


        if ($model->validate()){

            try{
            
                $model->save();
            
                $lead_id = $model->id;
                $this->actionAddPhoneNumber($lead_id,$phone_number,$name);
                $data = ['success' => true,'data' => $model,];
            }
             catch (Exception $ex) 
            {
                throw new \yii\web\HttpException(405, 'Error saving model');
            }

        }else{
            $data = ['success' => false,'data' => [], 'error' => $model->getErrors()];
        }

        
        $response = Yii::$app->response;
        $response->data = $data;
        
        return $response->data;
        
    }
    /**
     * Updates an existing Leads model.
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
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Leads model.
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
     * Finds the Leads model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Leads the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Leads::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionAddPhoneNumberFromPane()
    {
        $request = Yii::$app->request;
        $get = $request->get();
        $leadId = $get['leadId'];
        $name = $get['name'];
        $leadPhoneNumber = $get['leadPhoneNumber'];
        $this->actionAddPhoneNumber($leadId,$leadPhoneNumber,$name);
    }
    

    public function actionAddPhoneNumber($leadId,$leadPhoneNumber,$name)
    {
        $leadsPhoneNumber = new LeadsPhoneNumbers();
        $leadsPhoneNumber->phone_number = $leadPhoneNumber;
        $leadsPhoneNumber->lead_id = $leadId;
        $leadsPhoneNumber->name = $name;

        try 
        {
            $leadsPhoneNumber->save();
            $data = ['success' => true,'data' => $leadsPhoneNumber,];
        } 
        catch (Exception $ex) 
        {
            throw new \yii\web\HttpException(405, 'Error saving model');
        }

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $data;
        
        return $response->data;
    }


     public function actionGetLeadsPhoneNumbers()
    {
        $request = Yii::$app->request;
        $get = $request->get();
        $leadId = $get['leadId'];
        $this->actionGetLeadsPhoneNumbersByLeadId($leadId);
    }

    public function actionGetLeadsPhoneNumbersByLeadId($leadId)
    {

        $leadsPhoneNumbers = LeadsPhoneNumbers::find()
        ->where(['lead_id' => $leadId])
        ->all();

        $data = ['success' => true,'data' => $leadsPhoneNumbers];

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $data;
        
        return $response->data;
    } 


    public function actionDeleteLeadsPhoneNumber()
    {
        $request = Yii::$app->request;
        $get = $request->get();
        $leadId = $get['leadId'];
         $leadPhoneNumberId = $get['leadPhoneNumberId'];
        $this->actionDeleteLeadsPhoneNumberByPhone($leadId,$leadPhoneNumberId);
    }


    public function actionDeleteLeadsPhoneNumberByPhone($leadId,$leadPhoneNumberId)
    {
        
        $leadsPhoneNumbers = LeadsPhoneNumbers::findOne([
            'lead_id' => $leadId,
            'id' => $leadPhoneNumberId,
        ]);


        try 
        {
            $leadsPhoneNumbers->delete();
            $data = ['success' => true];
        } 
        catch (Exception $ex) 
        {
            $data = ['success' => false];
        }

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $data;
        
        return $response->data;
    }
    public function actionEditLeadsPhoneNumber()
    {
        $request = Yii::$app->request;
        $get = $request->get();
        $leadPhoneNumber = $get['leadPhoneNumber'];
        $leadPhoneNumberId = $get['leadPhoneNumberId'];
        $name = $get['name'];

        $this->actionEditLeadsPhoneNumberByPhoneId($leadPhoneNumber,$leadPhoneNumberId,$name);
    }


    public function actionEditLeadsPhoneNumberByPhoneId($leadPhoneNumber,$leadPhoneNumberId,$name)
    {
        $leadsPhoneNumber =  LeadsPhoneNumbers::findOne(['id' => $leadPhoneNumberId]);
        $leadsPhoneNumber->phone_number = $leadPhoneNumber;
        $leadsPhoneNumber->name = $name;
        try 
        {
            $leadsPhoneNumber->save();
            $data = ['success' => true,'data' => $leadsPhoneNumber,];
        } 
        catch (Exception $ex) 
        {
            throw new \yii\web\HttpException(405, 'Error saving model');
        }

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $data;
        
        return $response->data;

    }

    public function actionGetLeadDetail()
    {
        $get = Yii::$app->request->get();
        $leadId = $get['leadId'];
        $this->actionGetLeadDetailById($leadId);
    }

    public function actionGetLeadDetailById($leadId)
    {
        $lead = Leads::findOne(['id' => $leadId]);
        $data = ['success' => true,'data' => $lead];
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $data;
        
        return $response->data;
    }

    public function actionExistNumberByLead()
    {

    }
    
}
