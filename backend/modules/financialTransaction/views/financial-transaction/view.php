<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\financialTransaction\models\FinancialTransaction */
?>
<div class="expenses-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'category_id',
            'created_at',
            'created_by',
            'updated_at',
            'last_updated_by',
            'is_deleted',
            'description:ntext',
            'amount',
            'receiver_number',
            'document_number',
        ],
    ]) ?>

</div>
