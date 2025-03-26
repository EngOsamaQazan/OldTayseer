<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\judiciary\models\Judiciary;
use backend\modules\customers\models\Customers;
use backend\modules\judiciaryActions\models\JudiciaryActions;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use backend\modules\customers\models\ContractsCustomers;

/* @var $this yii\web\View */
/* @var $model backend\modules\judiciary\models\JudiciaryCustomersActions */
/* @var $form yii\widgets\ActiveForm */
/* @var $contractID */
$data = ContractsCustomers::find()
    ->select(['c.id', 'c.name'])
    ->alias('cc')
    ->innerJoin('{{%customers}} c', 'c.id=cc.customer_id')
    ->where(['cc.contract_id' => $contractID])
    ->createCommand()->queryAll();

?>
<div class="questions-bank box box-primary">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-6">
            <?=
            $form->field($model, 'judiciary_id')->widget(kartik\select2\Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map(Judiciary::find()->where(['contract_id' => $contractID])->all(), 'id', 'judiciary_number'),
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
                'data' => yii\helpers\ArrayHelper::map($data, 'id', 'name'),
                'options' => [
                    'placeholder' => 'Select a court.',
                    'type'=>'search'
                ],

            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?=
            $form->field($model, 'judiciary_actions_id')->widget(kartik\select2\Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map(JudiciaryActions::find()->all(), 'id', 'name'),
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
