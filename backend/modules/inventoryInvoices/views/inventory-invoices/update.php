<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\inventoryInvoices\models\InventoryInvoices */
?>
<div class="inventory-invoices-update">

    <?= $this->render('_form', [
        'model' => $model,
        'itemsInventoryInvoices'=>$itemsInventoryInvoices
    ]) ?>

</div>
