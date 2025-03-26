<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use borales\extensions\phoneInput\PhoneInput;
/* @var $this yii\web\View */
/* @var $model backend\modlues\customers\models\Customers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customers-form">

    <?php
    $form = ActiveForm::begin(['action' => Url::to(['customers/update-contact', 'id' => $id])]);
    ?>
    <?= $form->errorSummary($model) ?>

    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <label class="control-label"> رقم الهاتف الرئيسي </label>
            <br>
            <?= $form->field($model, 'primary_phone_number')->widget(PhoneInput::className(), [
                'jsOptions' => [
                    'preferredCountries' => ['jo'],
                ]
            ])->label(false);?>
        </div>
        <div class="col-sm-12 col-xs-12">
            <?= $form->field($model, 'facebook_account')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-12 col-xs-12">
            <?= $form->field($model, 'email')->textInput(); ?>
        </div>

    </div>

<div class="row mt-15">
    <div class="col-sm-6 col-xs-6">
        <?php if (!Yii::$app->request->isAjax) { ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        <?php } ?>

        <?php ActiveForm::end(); ?>

    </div>
</div>
</div>
<style>
    #customers-primary_phone_number{
        width: 238%;
    }
</style>