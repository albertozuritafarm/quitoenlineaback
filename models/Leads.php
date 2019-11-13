<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "leads".
 *
 * @property int $id
 * @property string $name
 * @property string $alt_name
 * @property string $renewal_date
 * @property int $attempts
 * @property string $status
 * @property string $completion_method
 * @property int $campaign_id
 * @property string $import_date
 * @property string $created_at
 *
 * @property CallHistory[] $callHistories
 * @property Campaigns $campaign
 * @property LeadsCustomFields[] $leadsCustomFields
 * @property LeadsPhoneNumbers[] $leadsPhoneNumbers
 */
class Leads extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leads';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'alt_name', 'renewal_date', 'attempts', 'status', 'completion_method'], 'required'],
            [['renewal_date', 'import_date', 'created_at'], 'safe'],
            [['attempts', 'campaign_id'], 'integer'],
            [['status', 'completion_method'], 'string'],
            [['name', 'alt_name'], 'string', 'max' => 255],
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => Campaigns::className(), 'targetAttribute' => ['campaign_id' => 'id']],
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
            'alt_name' => 'Alt Name',
            'renewal_date' => 'Renewal Date',
            'attempts' => 'Attempts',
            'status' => 'Status',
            'completion_method' => 'Completion Method',
            'campaign_id' => 'Campaign ID',
            'import_date' => 'Import Date',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCallHistories()
    {
        return $this->hasMany(CallHistory::className(), ['phone_number_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaign()
    {
        return $this->hasOne(Campaigns::className(), ['id' => 'campaign_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeadsCustomFields()
    {
        return $this->hasMany(LeadsCustomFields::className(), ['lead_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeadsPhoneNumbers()
    {
        return $this->hasMany(LeadsPhoneNumbers::className(), ['lead_id' => 'id']);
    }
}
