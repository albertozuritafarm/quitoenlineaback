<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Campaigns';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campaigns-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Campaigns', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'industry_template',
            'is_recurring',
            'start_date',
            //'end_date',
            //'corporation_id',
            //'check_duplicates',
            //'how_to_check_duplicates',
            //'how_to_handle_duplicate_in_list',
            //'how_to_handle_duplicate_activelly_called',
            //'caller_id',
            //'state_of_residency',
            //'max_number_of_attemps_per_lead',
            //'min_amount_time_between_attempts_days:datetime',
            //'min_amount_time_between_attempts_hours:datetime',
            //'search_counts_as_attempt',
            //'callback_link_counts_as_attempt',
            //'not_calling_counts_as_attempt',
            //'priority_attempt',
            //'call_order',
            //'priority',
            //'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
