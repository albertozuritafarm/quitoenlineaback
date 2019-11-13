<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Leads */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leads-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alt_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'renewal_date')->textInput() ?>

    <?= $form->field($model, 'attempts')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 'in_progress' => 'In progress', 'completed' => 'Completed', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'completion_method')->dropDownList([ 'call_result' => 'Call result', 'max_attempts' => 'Max attempts', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'campaign_id')->textInput() ?>

    <?= $form->field($model, 'import_date')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
