<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model backend\models\QuestionSearch */
/* @var $form yii\widgets\ActiveForm */
$type =    Yii::$app->cache->getOrSet(Yii::$app->params["key_income_category"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['income_category_query'])->queryAll();
}, Yii::$app->params['time_duration']);

$companies  =   Yii::$app->cache->getOrSet(Yii::$app->params["key_company"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['company_query'])->queryAll();
}, Yii::$app->params['time_duration']);

$payment_type  =   Yii::$app->cache->getOrSet(Yii::$app->params["key_payment_type"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['payment_type_query'])->queryAll();
}, Yii::$app->params['time_duration']);

$_by  =   Yii::$app->cache->getOrSet(Yii::$app->params["key_income_by"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['income_by_query'])->queryAll();
}, Yii::$app->params['time_duration']);

?>

<div class="questions-bank box box-primary">


    <?php
    $form = ActiveForm::begin([
        'id' => '_search',
        'method' => 'get',
        'action' => ['income-list'],
    ]);
    ?>
    <div class="row">
        <div class="col-lg-6">
            <?=
            $form->field($model, 'date_from')->widget(DatePicker::classname(), ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]]);
            ?>
        </div>
        <div class="col-lg-6">
            <?=
            $form->field($model, 'date_to')->widget(DatePicker::classname(), ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, '_by')->widget(kartik\select2\Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map($_by, '_by', '_by'),
                'options' => [
                    'placeholder' => 'Select a customer name.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'company_id')->widget(kartik\select2\Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map($companies, 'id', 'name'),
                'options' => [
                    'placeholder' => 'Select a company name.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'type')->widget(kartik\select2\Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map($type, 'id', 'name'),
                'options' => [
                    'placeholder' => 'Select a customer name.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'payment_type')->widget(kartik\select2\Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map($payment_type, 'id', 'name'),

                'options' => [
                    'placeholder' => 'Select a payment type.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'number_row')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

