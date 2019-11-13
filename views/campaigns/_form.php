<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Campaigns */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="campaigns-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'industry_template')->dropDownList([ 'birthday' => 'Birthday', 'prospecting' => 'Prospecting', 'hot_lead' => 'Hot lead', 'payment_declined' => 'Payment declined', 'payment_reminder' => 'Payment reminder', 'policy_review' => 'Policy review', 'three_months_quote_follow_up' => 'Three months quote follow up', 'life_cross_sale' => 'Life cross sale', 'satisfaction_survey' => 'Satisfaction survey', 'referral_request' => 'Referral request', 'event_notification' => 'Event notification', 'pre_renewall' => 'Pre renewall', 'winback' => 'Winback', 'welcome_call' => 'Welcome call', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'is_recurring')->textInput() ?>

    <?= $form->field($model, 'start_date')->textInput() ?>

    <?= $form->field($model, 'end_date')->textInput() ?>

    <?= $form->field($model, 'corporation_id')->textInput() ?>

    <?= $form->field($model, 'check_duplicates')->textInput() ?>

    <?= $form->field($model, 'how_to_check_duplicates')->dropDownList([ 'phone_numbers' => 'Phone numbers', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'how_to_handle_duplicate_in_list')->dropDownList([ 'import_duplicated' => 'Import duplicated', 'dont_import_duplicated' => 'Dont import duplicated', 'decide_individually' => 'Decide individually', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'how_to_handle_duplicate_activelly_called')->dropDownList([ 'import_duplicated' => 'Import duplicated', 'dont_import_duplicated' => 'Dont import duplicated', 'decide_individually' => 'Decide individually', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'caller_id')->textInput() ?>

    <?= $form->field($model, 'state_of_residency')->textInput() ?>

    <?= $form->field($model, 'max_number_of_attemps_per_lead')->textInput() ?>

    <?= $form->field($model, 'min_amount_time_between_attempts_days')->textInput() ?>

    <?= $form->field($model, 'min_amount_time_between_attempts_hours')->textInput() ?>

    <?= $form->field($model, 'search_counts_as_attempt')->textInput() ?>

    <?= $form->field($model, 'callback_link_counts_as_attempt')->textInput() ?>

    <?= $form->field($model, 'not_calling_counts_as_attempt')->textInput() ?>

    <?= $form->field($model, 'priority_attempt')->dropDownList([ 'first_attempt' => 'First attempt', 'subsequents_attempts' => 'Subsequents attempts', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'call_order')->dropDownList([ 'newest_first' => 'Newest first', 'oldest_first' => 'Oldest first', 'call_date' => 'Call date', 'randomized' => 'Randomized', 'alphabetically' => 'Alphabetically', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'priority')->dropDownList([ 'highest_priority' => 'Highest priority', 'second_priority' => 'Second priority', 'third_priority' => 'Third priority', 'forth_priority' => 'Forth priority', 'fifth_priority' => 'Fifth priority', 'lowest' => 'Lowest', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
