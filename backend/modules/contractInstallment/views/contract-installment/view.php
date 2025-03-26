<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\contractInstallment\models\contract-installment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Contact Installments', 'url' => ['index','contract_id'=>$contract_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="contact-installment-view box box-primary box-primary">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'contract_id',
            'date',
            'amount',
            'created_by',
            'payment_type',
            '_by',
            'receipt_bank',
            'payment_purpose',
        ],
    ]) ?>

</div>
