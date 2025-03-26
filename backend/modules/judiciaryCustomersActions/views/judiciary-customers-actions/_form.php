<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\judiciary\models\Judiciary;
use backend\modules\customers\models\Customers;
use backend\modules\judiciaryActions\models\JudiciaryActions;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\modules\judiciary\models\JudiciaryCustomersActions */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="questions-bank box box-primary">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-6">
            <?=
            $form->field($model, 'judiciary_id')->widget(kartik\select2\Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map(Judiciary::find()->all(), 'id', 'judiciary_number'),
                'language' => 'de',
                'options' => [
                    'placeholder' => 'Select a judiciary.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-lg-6">
            <?=
            $form->field($model, 'customers_id')->widget(kartik\select2\Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map(Customers::find()->all(), 'id', 'name'),
                'language' => 'de',
                'options' => [
                    'placeholder' => 'Select a customers.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('اسم العميل');
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?=
            $form->field($model, 'judiciary_actions_id')->widget(kartik\select2\Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map(JudiciaryActions::find()->all(), 'id', 'name'),
                'language' => 'de',
                'options' => [
                    'placeholder' => 'Select a judiciary action.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div>
            <?=
            $form->field($model, 'action_date')->widget(DatePicker::classname(), ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]])->label('تاريخ الحركة');
            ?>
        </div>
    </div>


    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>


    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
