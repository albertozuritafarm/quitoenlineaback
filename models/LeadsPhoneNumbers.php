<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "leads_phone_numbers".
 *
 * @property int $id
 * @property string $name
 * @property int $phone_number
 * @property int $lead_id
 *
 * @property Leads $lead
 */
class LeadsPhoneNumbers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leads_phone_numbers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone_number'], 'required'],
            [['phone_number', 'lead_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['lead_id'], 'exist', 'skipOnError' => true, 'targetClass' => Leads::className(), 'targetAttribute' => ['lead_id' => 'id']],
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
            'phone_number' => 'Phone Number',
            'lead_id' => 'Lead ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLead()
    {
        return $this->hasOne(Leads::className(), ['id' => 'lead_id']);
    }
}
