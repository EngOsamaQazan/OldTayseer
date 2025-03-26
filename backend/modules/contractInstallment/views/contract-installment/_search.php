<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\modules\contractInstallment\models\contract-installmentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="questions-bank box box-primary">
    <?php
    $form = ActiveForm::begin([
                'action' => ['index?contract_id=' . Yii::$app->getRequest()->getQueryParam('contract_id')],
                'method' => 'get',
    ]);
    ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, '_by') ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($model, 'date')->widget(DatePicker::classname(), ['pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
            ]]);
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'amount') ?>
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
