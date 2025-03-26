<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\paymentType\models\PaymentType */
?>
<div class="payment-type-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'created_at',
            'updated_at',
            'created_by',
            'last_updated_by',
            'is_deleted',
        ],
    ]) ?>

</div>
