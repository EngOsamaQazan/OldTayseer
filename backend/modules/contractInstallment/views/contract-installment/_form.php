<?php

use yii\helpers\Html;
use kartik\date\DatePicker;
use yii\widgets\ActiveForm;
use backend\modules\contractInstallment\models\ContractInstallment;
use backend\modules\incomeCategory\models\IncomeCategory;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\modules\contractInstallment\models\ContractInstallment */
/* @var $form yii\widgets\ActiveForm */


$origin = new DateTime($contract_model->first_installment_date);
$target = new DateTime(date('Y-m-d'));
$interval = $origin->diff($target);

$batches_should_be_paid_count = $interval->format('%R%m') + 1;
$amount_should_be_paid = $batches_should_be_paid_count * $contract_model->monthly_installment_value;

$paid_amount = ContractInstallment::find()
    ->andWhere(['contract_id' => $contract_model->id])
    ->sum('amount');

$deserved_amount = $amount_should_be_paid - $paid_amount;
?>


<div class="contact-installment-form">
    <div class="row">
        <div class="col-sm-6" style="text-align: right">
            <h5>
                <code>
                    المبلغ الذي يجب دفعه حتى هذا التاريخ
                    : <?= ($amount_should_be_paid > 0) ? $amount_should_be_paid : 0 ?>
                </code>
            </h5>
        </div>
        <div class="col-sm-3" style="text-align: right">

            <h5>
                <code>
                    حالة العقد :<?= isset($contract_model->status) ? Yii::t('app', $contract_model->status) : 0 ?>
                </code>
            </h5>
        </div>
        <div class="col-sm-3" style="text-align: right">
            <h5>
                <code>
                     قيمة الدفعة الشهرية
                    : <?= isset($contract_model->monthly_installment_value) ? $contract_model->monthly_installment_value : 0 ?>
                </code>
            </h5>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-3" style="text-align: right">

        </div>
        <div class="col-sm-3" style="text-align: right">

        </div>
        <div class="col-sm-3" style="text-align: right">
            <h5>
                <code>
                    المبلغ المدفوع : <?= ($paid_amount > 0) ? $amount_should_be_paid : 0 ?>
                </code>
            </h5>
        </div>
        <div class="col-sm-3" style="text-align: right">
            <h5>
                <code>
                    القيمة المستحقة :
                    <?php

                        if ($contract_model->status == 'judiciary') {
                            if ($contract_model->is_loan == 1) {
                                $cost = \backend\modules\judiciary\models\Judiciary::find()->where(['contract_id' => $contract_model->id])->where(['>=', 'created_at', $contract_model->created_at])->orderBy(['contract_id' => SORT_DESC])->one();

                            } else {
                                $cost = \backend\modules\judiciary\models\Judiciary::find()->where(['contract_id' => $contract_model->id])->orderBy(['contract_id' => SORT_DESC])->one();
                            }

                            if (!empty($cost)) {
                                if ($cost->created_at >= $contract_model->created_at) {
                                    $p = ($paid_amount > 0) ? $paid_amount : 0;


                                    $deserved_amount = ($contract_model->total_value) - ($p);
                                    echo $deserved_amount;
                                } else {
                                    echo ($deserved_amount > 0) ? $deserved_amount : 0;
                                }
                            } else {
                                echo $contract_model->total_value;
                            }
                        } else {
                            echo ($deserved_amount > 0) ? $deserved_amount : 0;
                        }
                        ?>
                    ?>
                </code>
            </h5>
        </div>
    </div>
</div>
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'contract_id')->hiddenInput(['value' => $contract_id])->label(false) ?>

<div class="row">
    <div class="col-sm-6">
        <?=
        $form->field($model, 'date')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Enter payment date ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ]);
        ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'amount')->textInput() ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <?= $form->field($model, 'payment_type')->dropDownList(yii\helpers\ArrayHelper::map(\backend\modules\paymentType\models\PaymentType::find()->all(),'id','name'), ['maxlength' => true]) ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'receipt_bank')->textInput(['maxlength' => true]) ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <?= $form->field($model, '_by')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'payment_purpose')->textInput(['maxlength' => true])?>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <?= $form->field($model, 'type')->dropDownList(yii\helpers\ArrayHelper::map(IncomeCategory::find()->all(), 'id', 'name'), ['maxlength' => true]) ?>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create & Print') : Yii::t('app', 'Update & Print'), ['name' => 'print', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php if (!Yii::$app->request->isAjax) { ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php } ?></div>

<?php ActiveForm::end(); ?>

</div>
