<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "campaigns".
 *
 * @property int $id
 * @property string $name
 * @property string $industry_template
 * @property int $is_recurring
 * @property string $start_date
 * @property string $end_date
 * @property int $corporation_id
 * @property int $check_duplicates
 * @property string $how_to_check_duplicates
 * @property string $how_to_handle_duplicate_in_list
 * @property string $how_to_handle_duplicate_activelly_called
 * @property int $caller_id
 * @property int $state_of_residency
 * @property int $max_number_of_attemps_per_lead
 * @property int $min_amount_time_between_attempts_days
 * @property int $min_amount_time_between_attempts_hours
 * @property int $search_counts_as_attempt
 * @property int $callback_link_counts_as_attempt
 * @property int $not_calling_counts_as_attempt
 * @property string $priority_attempt
 * @property string $call_order
 * @property string $priority
 * @property string $created_at
 *
 * @property CallHistory[] $callHistories
 * @property CallResultsSettings[] $callResultsSettings
 * @property CallResultsSettingsCampaign[] $callResultsSettingsCampaigns
 * @property CampaignColumns[] $campaignColumns
 * @property CampaignCustomColumns[] $campaignCustomColumns
 * @property CampaignScript[] $campaignScripts
 * @property CampaignUser[] $campaignUsers
 * @property Corporation $corporation
 * @property States $stateOfResidency
 * @property Leads[] $leads
 */
class Campaigns extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'campaigns';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'industry_template', 'is_recurring', 'start_date', 'end_date', 'check_duplicates', 'how_to_handle_duplicate_in_list', 'how_to_handle_duplicate_activelly_called', 'caller_id', 'state_of_residency', 'max_number_of_attemps_per_lead', 'min_amount_time_between_attempts_days', 'min_amount_time_between_attempts_hours', 'search_counts_as_attempt', 'callback_link_counts_as_attempt', 'not_calling_counts_as_attempt', 'priority_attempt', 'call_order', 'priority'], 'required'],
            [['industry_template', 'how_to_check_duplicates', 'how_to_handle_duplicate_in_list', 'how_to_handle_duplicate_activelly_called', 'priority_attempt', 'call_order', 'priority'], 'string'],
            [['is_recurring', 'corporation_id', 'check_duplicates', 'caller_id', 'state_of_residency', 'max_number_of_attemps_per_lead', 'min_amount_time_between_attempts_days', 'min_amount_time_between_attempts_hours', 'search_counts_as_attempt', 'callback_link_counts_as_attempt', 'not_calling_counts_as_attempt'], 'integer'],
            [['start_date', 'end_date', 'created_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['corporation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Corporation::className(), 'targetAttribute' => ['corporation_id' => 'id']],
            [['state_of_residency'], 'exist', 'skipOnError' => true, 'targetClass' => States::className(), 'targetAttribute' => ['state_of_residency' => 'id']],
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
            'industry_template' => 'Industry Template',
            'is_recurring' => 'Is Recurring',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'corporation_id' => 'Corporation ID',
            'check_duplicates' => 'Check Duplicates',
            'how_to_check_duplicates' => 'How To Check Duplicates',
            'how_to_handle_duplicate_in_list' => 'How To Handle Duplicate In List',
            'how_to_handle_duplicate_activelly_called' => 'How To Handle Duplicate Activelly Called',
            'caller_id' => 'Caller ID',
            'state_of_residency' => 'State Of Residency',
            'max_number_of_attemps_per_lead' => 'Max Number Of Attemps Per Lead',
            'min_amount_time_between_attempts_days' => 'Min Amount Time Between Attempts Days',
            'min_amount_time_between_attempts_hours' => 'Min Amount Time Between Attempts Hours',
            'search_counts_as_attempt' => 'Search Counts As Attempt',
            'callback_link_counts_as_attempt' => 'Callback Link Counts As Attempt',
            'not_calling_counts_as_attempt' => 'Not Calling Counts As Attempt',
            'priority_attempt' => 'Priority Attempt',
            'call_order' => 'Call Order',
            'priority' => 'Priority',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCallHistories()
    {
        return $this->hasMany(CallHistory::className(), ['campaign_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCallResultsSettings()
    {
        return $this->hasMany(CallResultsSettings::className(), ['campaign_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCallResultsSettingsCampaigns()
    {
        return $this->hasMany(CallResultsSettingsCampaign::className(), ['campaign_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaignColumns()
    {
        return $this->hasMany(CampaignColumns::className(), ['campaign_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaignCustomColumns()
    {
        return $this->hasMany(CampaignCustomColumns::className(), ['campaign_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaignScripts()
    {
        return $this->hasMany(CampaignScript::className(), ['campaign_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaignUsers()
    {
        return $this->hasMany(CampaignUser::className(), ['campaign_id' => 'id']);
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
    public function getStateOfResidency()
    {
        return $this->hasOne(States::className(), ['id' => 'state_of_residency']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeads()
    {
        return $this->hasMany(Leads::className(), ['campaign_id' => 'id']);
    }
    
}
