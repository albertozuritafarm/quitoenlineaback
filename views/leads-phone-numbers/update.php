<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LeadsPhoneNumbers */

$this->title = 'Update Leads Phone Numbers: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Leads Phone Numbers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="leads-phone-numbers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
