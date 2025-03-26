<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\customers */
?>
<div class="customers-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'status',
            'city',
            'bank_info',
            'job_title',
            'id_number',
        ],
    ]) ?>

</div>
