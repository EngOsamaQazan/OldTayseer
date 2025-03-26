<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use \backend\modules\status\models\Status;
/* @var $this yii\web\View */
/* @var $model backend\modules\loanScheduling\models\LoanScheduling */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="questions-bank box box-primary">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'monthly_installment')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?=
            $form->field($model, 'first_installment_date')->widget(DatePicker::class, ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?=
            $form->field($model, 'new_installment_date')->widget(DatePicker::class, ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]]);
            ?>
        </div>
        <?php if (!$model->isNewRecord) { ?>

            <div class="col-md-6">
                <?=  $form->field($model, 'status')->widget(Select2::class, [
                    'data' => \yii\helpers\ArrayHelper::map(Status::find()->all(),'id','name'),
                    'options' => [
                        'placeholder' => 'Select a status.',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>

            </div>
        <?php } ?>

    </div>

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
