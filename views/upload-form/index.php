<?php
use yii\widgets\ActiveForm;
use app\models\UploadForm;
?>

<?php 
$model = new UploadForm();
$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'file')->fileInput() ?>

<button>Submit</button>

<?php ActiveForm::end() ?>