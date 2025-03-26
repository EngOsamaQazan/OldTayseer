<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use backend\modules\expenseCategories\models\ExpenseCategories;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\modules\contracts\models\Contracts;
use backend\modules\financialTransaction\models\FinancialTransaction;
use backend\modules\companies\models\Companies;
use backend\modules\incomeCategory\models\IncomeCategory;

/* @var $this yii\web\View */
/* @var $model backend\modules\financialTransaction\models\FinancialTransaction */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="questions-bank box box-primary">
        <?php Html::dropDownList('') ?>
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-lg-6">

                <?= $form->field($model, 'amount')->textInput() ?>
            </div>
            <div class="col-lg-6 ">
                <?= $form->field($model, 'company_id')->widget(Select2::classname(), [
                    'data' => yii\helpers\ArrayHelper::map(Companies::find()->all(), 'id', 'name'),
                    'language' => 'de',
                    'options' => [
                        'placeholder' => 'Select a company.',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(Yii::t('app','Company Id')); ?>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">

                <?= $form->field($model, 'receiver_number')->textInput()->label(Yii::t('app','Receiver Number'));?>

            </div>
            <div class="col-lg-6 type">

                <?= $form->field($model, 'type')->widget(Select2::classname(), [
                    'data' => ['', 'Income', 'Outcome'],
                    'language' => 'de',
                    'options' => [
                        'placeholder' => 'Select a type.',
                        'class' => 'type'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(Yii::t('app','type')); ?>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 category" style="display:none;">
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
            <div class="col-lg-6 income" style="display: none">
                <?= $form->field($model, 'income_type')->widget(Select2::classname(), [
                    'data' => yii\helpers\ArrayHelper::map(IncomeCategory::find()->all(),'id','name'),
                    'language' => 'de',
                    'options' => [
                        'placeholder' => 'Select a income type.',
                        'class' => 'income'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>
            <div class="col-lg-6 contract" style="display: none">
                <?= $form->field($model, 'contract_id')->widget(Select2::classname(), [
                    'data' => yii\helpers\ArrayHelper::map(Contracts::find()->all(), 'id', 'id'),
                    'language' => 'de',
                    'options' => [
                        'placeholder' => 'Select a contract.',
                        'class' => 'contract'

                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],]);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <?= $form->field($model, 'description')->textarea(['rows' => '6']) ?>
            </div>
        </div>
    <div
        <?php if (!Yii::$app->request->isAjax) { ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        <?php } ?>


        <?php ActiveForm::end(); ?>

    </div>
<?php
$typeIncome = FinancialTransaction::TYPE_INCOME;
$typeOutcome = FinancialTransaction::TYPE_OUTCOME;
$TypeIncomeMonth = FinancialTransaction::TYPE_INCOME_MONTHLY;
$typeIncomeOther = FinancialTransaction::TYPE_INCOME_OTHER;
$this->registerJs(<<<SCRIPT
$(document).on('change','.type',function(){
    let type = $(this).val();
    if(type == $typeIncome){
    $('.income').css({'display':'inline'});
     $('.category').css({'display':'none'});
    }
    if(type == $typeOutcome){
     $('.income').css({'display':'none'});
      $('.contract').css({'display':'none'});
       $('.contract').css({'display':'none'});
    $('.category').css({'display':'inline'});
   
    }
  
});
$(document).on('change','.income',function(){
        let income = $(this).val();
        if(income == $TypeIncomeMonth){
         $('.contract').css({'display':'inline'});
        }
         if(income == $typeIncomeOther){
         $('.contract').css({'display':'none'});
        }
       
});
SCRIPT
);
?>