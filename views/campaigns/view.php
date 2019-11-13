<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Campaigns */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="campaigns-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'industry_template',
            'is_recurring',
            'start_date',
            'end_date',
            'corporation_id',
            'check_duplicates',
            'how_to_check_duplicates',
            'how_to_handle_duplicate_in_list',
            'how_to_handle_duplicate_activelly_called',
            'caller_id',
            'state_of_residency',
            'max_number_of_attemps_per_lead',
            'min_amount_time_between_attempts_days:datetime',
            'min_amount_time_between_attempts_hours:datetime',
            'search_counts_as_attempt',
            'callback_link_counts_as_attempt',
            'not_calling_counts_as_attempt',
            'priority_attempt',
            'call_order',
            'priority',
            'created_at',
        ],
    ]) ?>

</div>
