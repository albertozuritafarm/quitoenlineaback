<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LeadsPhoneNumbers */

$this->title = 'Create Leads Phone Numbers';
$this->params['breadcrumbs'][] = ['label' => 'Leads Phone Numbers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leads-phone-numbers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
