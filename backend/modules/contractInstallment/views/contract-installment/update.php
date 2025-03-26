<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\contractInstallment\models\contract-installment */

$this->title = 'Update Contact Installment: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Contact Installments', 'url' => ['index', 'contract_id' => $model->contract_id]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="contact-installment-update box box-primary box-primary">

    <?=
    $this->render('_form', [
        'model' => $model,
        'contract_id' => $contract_id,
        'contract_model' => $contract_model
    ])
    ?>

</div>
