<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\LearningObjective;
use yii\helpers\ArrayHelper;
use backend\modules\contracts\models\Contracts;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\QuestionSearch */
/* @var $form yii\widgets\ActiveForm */

$customers  =   Yii::$app->cache->getOrSet(Yii::$app->params["key_customers"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['customers_query'])->queryAll();
}, Yii::$app->params['time_duration']);
$users  =   Yii::$app->cache->getOrSet(Yii::$app->params["key_users"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['users_query'])->queryAll();
}, Yii::$app->params['time_duration']);
$job_type = Yii::$app->cache->getOrSet(Yii::$app->params["key_job_type"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['job_type_query'])->queryAll();
}, Yii::$app->params['time_duration']);
$jobs = Yii::$app->cache->getOrSet(Yii::$app->params["key_jobs"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['jobs_query'])->queryAll();
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
            $form->field($model, 'from_date')->widget(kartik\date\DatePicker::class, ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]]);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($model, 'to_date')->widget(kartik\date\DatePicker::class, ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]]);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($model, 'seller_id')->widget(kartik\select2\Select2::class, [
                'data' =>yii\helpers\ArrayHelper::map($users, 'id', 'username'),
                'options' => [
                    'placeholder' => 'Select a customer name.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>

    </div>
    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($model, 'status')->dropDownList(['' => 'All', 'pending' => 'pending', 'active' => 'active', 'reconciliation' => 'reconciliation', 'judiciary' => 'judiciary', 'canceled' => 'canceled', 'refused' => 'refused', 'legal_department' => 'legal_department', 'finished' => 'finished', 'settlement' => 'settlement']);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($model, 'id')->textInput();
            ?>
        </div>
        <div class="col-md-4">

            <?= $form->field($model, 'followed_by')->widget(kartik\select2\Select2::class, [
                'data' => yii\helpers\ArrayHelper::map($users, 'id', 'username'),

                'options' => [
                    'placeholder' => 'Select a customer name.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'phone_number')->textInput();
            ?>
        </div>
        <div class="col-md-4">

            <?= $form->field($model, 'customer_name')->widget(kartik\select2\Select2::class, [
                'data' => yii\helpers\ArrayHelper::map($customers, 'id', 'name'),

                 'options' => [
                    'placeholder' => 'Select a customer name.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(Yii::t('app', 'Customer Name'));
            ?>
        </div>
            <div class="col-lg-4">
                <?= $form->field($model, 'number_row')->textInput(['maxlength' => true]) ?>
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
        </div>     <div class="col-md-4">
            <?= $form->field($model, 'job_title')->widget(kartik\select2\Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map($jobs, 'id', 'name'),
                'options' => [
                    'placeholder' => 'Select a customer name.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
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
