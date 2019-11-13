<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "corporation".
 *
 * @property int $id
 * @property string $name
 *
 * @property BackendUsers[] $backendUsers
 * @property Campaigns[] $campaigns
 * @property CorporateSettings[] $corporateSettings
 */
class Corporation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'corporation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBackendUsers()
    {
        return $this->hasMany(BackendUsers::className(), ['corporation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaigns()
    {
        return $this->hasMany(Campaigns::className(), ['corporation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorporateSettings()
    {
        return $this->hasMany(CorporateSettings::className(), ['corporation_id' => 'id']);
    }
}
