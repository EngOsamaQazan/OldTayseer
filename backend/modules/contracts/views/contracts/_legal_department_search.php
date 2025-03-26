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
?>

<div class="questions-bank box box-primary">


    <?php
    $form = ActiveForm::begin([
        'id' => '_search',
        'method' => 'get',
        'action' => ['contracts/legal-department'],
    ]);
    ?>
    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($model, 'from_date')->widget(DatePicker::classname(), ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]])->label(Yii::t('app', 'From Date'));
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($model, 'to_date')->widget(DatePicker::classname(), ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]])->label(Yii::t('app', 'To Date'));
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'seller_id')->widget(kartik\select2\Select2::classname(), [
                'data' =>yii\helpers\ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username'),
                'options' => [
                    'placeholder' => 'Select a seller.',
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
            <?= $form->field($model, 'customer_name')->widget(kartik\select2\Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map(\backend\modules\customers\models\Customers::find()->where(['is_deleted' => 0])->all(), 'name', 'name'),
                'options' => [
                    'placeholder' => 'Select a customer name.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(Yii::t('app', 'Customer Name'));
            ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'id')->widget(kartik\select2\Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map(\backend\modules\contracts\models\Contracts::find()->where(['status' => 'legal_department'])->where(['is_deleted'=>0])->all(), 'id', 'id'),
                'options' => [
                    'placeholder' => 'Select a id.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'followed_by')->widget(kartik\select2\Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username'),
                'options' => [
                    'placeholder' => 'Select a followed by.',
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
            <?= $form->field($model, 'type')->widget(kartik\select2\Select2::classname(), [
                'data' => ['normal'=>'normal','solidarity'=>'solidarity'],
                'options' => [
                    'placeholder' => 'Select a customer name.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(Yii::t('app', 'type'));
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'job_title')->widget(kartik\select2\Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map(\backend\modules\jobs\models\Jobs::find()->all(),'id','name'),
                'options' => [
                    'placeholder' => 'Select a job title.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(Yii::t('app', 'المسمى الوظيفي'));
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'phone_number')->textInput();
            ?>
        </div>
    </div>
    <div class="row">
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
