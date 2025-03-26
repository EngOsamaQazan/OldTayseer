<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\contractInstallment\models\contract-installment */

$this->title = Yii::t('app', 'Create Contact Installment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contact Installments'), 'url' => ['index', 'contract_id' => $contract_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-installment-create box box-primary box-primary">

    <?=
    $this->render('_form', [
        'model' => $model,
        'contract_id' => $contract_id,
        'contract_model' => $contract_model
    ])
    ?>

</div>
