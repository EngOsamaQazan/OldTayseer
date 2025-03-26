
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\QuestionSearch */
/* @var $form yii\widgets\ActiveForm */
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

            <?= $form->field($model, 'id') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'seller_name') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'customer_name')->label(Yii::t('app', 'Customer Name')) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($model, 'Date_of_sale')->widget(DatePicker::classname(), ['pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
            ]]);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($model, 'first_installment_date')->widget(DatePicker::classname(), ['pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
            ]]);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($model, 'date_time')->widget(DatePicker::classname(), ['pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
            ]]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($model, 'promise_to_pay_at')->widget(DatePicker::classname(), ['pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
            ]]);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($model, 'reminder')->widget(DatePicker::classname(), ['pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
            ]]);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($model, 'status')->dropDownList(['' => 'All', 'pending' => 'pending', 'active' => 'active', 'reconciliation' => 'reconciliation', 'judiciary' => 'judiciary', 'canceled' => 'canceled', 'refused' => 'refused', 'legal_department' => 'legal_department', 'finished' => 'finished', 'settlement' => 'settlement']);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'number_row')->textInput(['maxlength' => true]) ?>
        </div>
        <?php if(Yii::$app->user->can('مدير') or Yii::$app->user->can(' مدير التحصيل')){ ?>
        <div class="col-lg-4">
            <?= $form->field($model, 'followed_by')->widget(kartik\select2\Select2::classname(), [
                'data' =>yii\helpers\ArrayHelper::map( Yii::$app->cache->getOrSet(Yii::$app->params["key_users"], function () {
                    return Yii::$app->db->createCommand(Yii::$app->params['users_query'])->queryAll();
                }, Yii::$app->params['time_duration']), 'id', 'username'),
                'options' => [
                    'placeholder' => 'Select a created_by.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <?php } ?>
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
