<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;
use yii\base\Security;

/**
 * This is the model class for table "backend_users".
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property int $account_locked
 * @property string $status
 * @property string $cellphone
 * @property int $corporation_id
 * @property string $created_at
 * @property string $password
 * @property string $authKey
 * @property string $pasword_reset_token
 * @property int $practice_calling_approved
 *
 * @property Corporation $corporation
 * @property CallHistory[] $callHistories
 * @property CallersFeedback[] $callersFeedbacks
 * @property CallersFeedback[] $callersFeedbacks0
 * @property CampaignUser[] $campaignUsers
 * @property MessageDrop[] $messageDrops
 * @property UserAssingments[] $userAssingments
 * @property UserSettings[] $userSettings
 * @property WidgetsUsers[] $widgetsUsers
 */
class BackendUsers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'backend_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'username', 'email', 'account_locked', 'status', 'cellphone', 'password', 'practice_calling_approved'], 'required'],
            [['id', 'account_locked', 'corporation_id', 'practice_calling_approved'], 'integer'],
            [['status'], 'string'],
            [['created_at'], 'safe'],
            [['name', 'username', 'email', 'profile_picture','cellphone', 'password', 'authKey', 'pasword_reset_token'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['id'], 'unique'],
            [['corporation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Corporation::className(), 'targetAttribute' => ['corporation_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'username' => 'Username',
            'email' => 'Email',
            'profile_picture' => 'Profile Picture',
            'account_locked' => 'Account Locked',
            'status' => 'Status',
            'cellphone' => 'Cellphone',
            'corporation_id' => 'Corporation ID',
            'created_at' => 'Created At',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'pasword_reset_token' => 'Pasword Reset Token',
            'practice_calling_approved' => 'Practice Calling Approved',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorporation()
    {
        return $this->hasOne(Corporation::className(), ['id' => 'corporation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCallHistories()
    {
        return $this->hasMany(CallHistory::className(), ['caller_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCallersFeedbacks()
    {
        return $this->hasMany(CallersFeedback::className(), ['sender' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCallersFeedbacks0()
    {
        return $this->hasMany(CallersFeedback::className(), ['receiver' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaignUsers()
    {
        return $this->hasMany(CampaignUser::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessageDrops()
    {
        return $this->hasMany(MessageDrop::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAssingments()
    {
        return $this->hasMany(UserAssingments::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserSettings()
    {
        return $this->hasMany(UserSettings::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWidgetsUsers()
    {
        return $this->hasMany(WidgetsUsers::className(), ['user_id' => 'id']);
    }

    public function HelloWorld()
    {
        return array(
            'success' => true,
            'message' => 'Hello World'
        );
    }

    public function LoginBackendUser($username,$password)
    {
        $user = BackendUsers::findOne([
            'username' => $username,
        ]);

        if ($user and (Yii::$app->getSecurity()->validatePassword($password, $user['password'])))
        {
            $statusCode = 200;
            $data = ['success' => true,'data' => $user,];    
        }else
        {
            $statusCode = 401;
            $data = ['success' => false, 'data' => [],];
        }

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $data;
        $response->statusCode = $statusCode;
        
        return $response->data;        
    }
}
