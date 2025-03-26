<?php

use backend\modules\loanScheduling\models\LoanScheduling;
use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\contractInstallment\models\ContractInstallment;
use backend\modules\contracts\models\Contracts;
use common\helper\LoanContract;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\contractInstallment\models\ContractInstallmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contact Installments');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$modelf = new LoanContract;
$contract_model = $modelf->findContract($contract_id);
$d1 = new DateTime($contract_model->first_installment_date);
$d2 = new DateTime(date('Y-m-d'));
$interval = $d2->diff($d1);
if ($contract_model->status == 'judiciary') {
    $cost = \backend\modules\judiciary\models\Judiciary::find()->where(['contract_id' => $contract_model->id])->all();

    foreach ($cost as $cost) {
        $totle_value = $contract_model->total_value + $cost->case_cost + $cost->lawyer_cost;
        $contract_model->total_value = $totle_value;
    }
    $contract_model->total_value;
}
$interval = $interval->y * 12 + $interval->m;

$batches_should_be_paid_count = $interval + 1;
$amount_should_be_paid = (($batches_should_be_paid_count * $contract_model->monthly_installment_value) < $contract_model->total_value) ? $batches_should_be_paid_count * $contract_model->monthly_installment_value : $contract_model->total_value;

if ($contract_model->is_loan == 1) {
    $paid_amount = ContractInstallment::find()
                    ->andWhere(['contract_id' => $contract_model->id])->andwhere(['>', 'date', $contract_model->loan_scheduling_new_instalment_date])->sum('amount');
} else {
    $paid_amount = ContractInstallment::find()
            ->andWhere(['contract_id' => $contract_model->id])
            ->sum('amount');
}
?>
<?php //echo $this->render('_search', ['model' => $searchModel]);        ?>
<div class="contact-installment-index box box-primary box-primary">
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
                        المبلغ المدفوع : <?= ($paid_amount > 0) ? $paid_amount : 0 ?>
                    </code>
                </h5>
            </div>
            <div class="col-sm-3" style="text-align: right">
                <h5>
                    <code>
                        القيمة المستحقة :      
                            <?php
                        $amount_should_be_paid = ($amount_should_be_paid > 0) ? $amount_should_be_paid : 0;
                        if ($amount_should_be_paid >= $contract_model->total_value) {
                            echo $contract_model->total_value;
                        } else {
                            echo $amount_should_be_paid;
                        }
                        ?>
                    </code>
                </h5>
            </div>
        </div>
    </div>

    <p>
        <?=Html::a(Yii::t('app', 'Add Contact Installment'), ['create', 'contract_id' => $contract_id], ['class' => 'btn btn-success'])
        ?>
    </p>


    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'summary' => false,
        'columns' => [
            'date',
            'amount',
            'payment_type',
            'receipt_bank',
            'payment_purpose',
            '_by',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete} {view} {print}',
                'buttons' => [
                    'print' => function ($url, $model) {
                        return \yii\helpers\Html::a('<span class="glyphicon glyphicon-print"></span>', \yii\helpers\Url::toRoute(['contract-installment/print', 'id' => $model->id]), ['aria-label' => 'Clone', 'title' => 'Clone']);
                    },
                ],
            ],
        ],
    ]);
    ?>


</div>
