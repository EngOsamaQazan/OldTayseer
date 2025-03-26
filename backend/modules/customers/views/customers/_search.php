<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\LearningObjective;
use yii\helpers\ArrayHelper;
use \backend\modules\status\models\Status;
/* @var $this yii\web\View */
/* @var $model backend\models\QuestionSearch */
/* @var $form yii\widgets\ActiveForm */

$users =   Yii::$app->cache->getOrSet(Yii::$app->params["key_users"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['users_query'])->queryAll();
}, Yii::$app->params['time_duration']);

$status =   Yii::$app->cache->getOrSet(Yii::$app->params["key_status"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['status_query'])->queryAll();
}, Yii::$app->params['time_duration']);

$customers  =   Yii::$app->cache->getOrSet(Yii::$app->params["key_customers_name"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['customers_name_query'])->queryAll();
}, Yii::$app->params['time_duration']);

$city = Yii::$app->cache->getOrSet(Yii::$app->params["key_city"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['city_query'])->queryAll();
}, Yii::$app->params['time_duration']);
$job_type = Yii::$app->cache->getOrSet(Yii::$app->params["key_job_type"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['job_type_query'])->queryAll();
}, Yii::$app->params['time_duration']);

$jobs = Yii::$app->cache->getOrSet(Yii::$app->params["key_jobs"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['jobs_query'])->queryAll();
}, Yii::$app->params['time_duration']);

$contract_status = Yii::$app->cache->getOrSet(Yii::$app->params["key_contract_status"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['contract_status_query'])->queryAll();
}, Yii::$app->params['time_duration']);
?>

<div class="questions-bank box box-primary">


    <?php
    $form = ActiveForm::begin([
        'id' => '_search',
        'method' => 'get',
        'action' => ['index'],
    ]);
    ?>
    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($model, 'status')->dropDownList(yii\helpers\ArrayHelper::map($status, 'id', 'name'), ['prompt' => \Yii::t('app', "all status")])
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'name')->widget(kartik\select2\Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map($customers, 'name', 'name'),
                'options' => [
                    'placeholder' => 'Select a customer name.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'id') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($model, 'city')->dropDownList(yii\helpers\ArrayHelper::map($city,'id','name'), ['prompt' => \Yii::t('app', "all cites")]);
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'id_number') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'primary_phone_number') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($model, 'job_title')->widget(kartik\select2\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map($jobs, 'id', 'name'),
                'language' => 'de',
                'options' => [
                    'placeholder' => 'Select a Jobs.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'contract_type')->widget(kartik\select2\Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map($contract_status, 'status', 'status'),
                'options' => [
                    'placeholder' => 'Select a customer name.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(Yii::t('app', 'Contract Type'));
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'job_Type')->widget(kartik\select2\Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map($job_type, 'id', 'name'),
                'options' => [
                    'placeholder' => 'Select a customer name.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
            <div class="col-lg-4">
                <?= $form->field($model, 'number_row')->textInput(['maxlength' => true]) ?>
            </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>


    </div>
    <?php ActiveForm::end(); ?>

</div>
