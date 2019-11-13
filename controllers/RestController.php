<?php

namespace app\controllers;

use sizeg\jwt\Jwt;
use sizeg\jwt\JwtHttpBearerAuth;
use Yii;
use yii\rest\Controller;
use app\models\BackendUsers;
use app\models\Session;
use yii\filters\auth\HttpBasicAuth;

class RestController extends Controller
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


    public function actionLogin()
    {
        // here you can put some credentials validation logic
        // so if it success we return token

        $request = Yii::$app->request;
        $get = $request->get();
        $username = $get['username'];
        $password = $get['password'];
        
        $BackendUser = new BackendUsers();
        $data = $BackendUser->LoginBackendUser($username,$password);
        
       
        

        if ($data["success"] == true)
        {
           
            $UserSession = new Session();
            $userId = $data['data']['id'];
            $UserSession->setSession($userId);
            $token = $this->actionGenerateToken($data['data']['id']);
            return $this->asJson(['token' => (string)$token,'userId' => $userId]);
        }else
        {
           return $this->asJson($data);
        }
    }


    public function actionGenerateToken($userId)
    {
        $signer = new \Lcobucci\JWT\Signer\Hmac\Sha256();
        /** @var Jwt $jwt */
        $jwt = Yii::$app->jwt;
        $token = $jwt->getBuilder()
            ->setIssuer('http://localhost::8080/Dialio-API/web/rest')// Configures the issuer (iss claim)
            ->setAudience('http://localhost::8080/Dialio-API/web/rest')// Configures the audience (aud claim)
            ->setId('4f1g23a12aa', true)// Configures the id (jti claim), replicating as a header item
            ->setIssuedAt(time())// Configures the time that the token was issue (iat claim)
            ->setExpiration(time() + 36000)// Configures the expiration time of the token (exp claim)
            ->set('uid', 100)// Configures a new claim, called "uid"
            ->sign($signer, $jwt->key)// creates a signature using [[Jwt::$key]]
            ->getToken(); // Retrieves the generated token

        //return $this->asJson(['token' => (string)$token,'userId' => $userId]);
        return $token;
    }

    public function actionData()
    {
        return $this->asJson(['success' => true,]);
    }
}