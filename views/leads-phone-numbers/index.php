<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Leads Phone Numbers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leads-phone-numbers-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Leads Phone Numbers', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'phone_number',
            'lead_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
