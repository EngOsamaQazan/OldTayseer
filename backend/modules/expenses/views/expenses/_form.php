<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\expenseCategories\models\ExpenseCategories;
use backend\modules\contracts\models\Contracts;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Expenses */
/* @var $form yii\widgets\ActiveForm */
$users =  Yii::$app->cache->getOrSet(Yii::$app->params["key_users"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['users_query'])->queryAll();
}, Yii::$app->params['time_duration']);

$contract_id =  Yii::$app->cache->getOrSet(Yii::$app->params["key_contract_id"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['contract_id_query'])->queryAll();
}, Yii::$app->params['time_duration']);
?>

<div class="questions-bank box box-primary">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-6 category">
            <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map(ExpenseCategories::find()->all(), 'id', 'name'),
                'language' => 'de',
                'options' => [
                    'placeholder' => 'Select a categories.',
                    'class' => 'catgery'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'amount')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'receiver_number')->textInput() ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'expenses_date')->widget(DatePicker::classname(), ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'document_number')->textInput() ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'contract_id')->widget(kartik\select2\Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map($contract_id, 'id', 'id'),
                'options' => [
                    'placeholder' => 'Select a expenses.',
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

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>
        </div>
    </div>
    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
