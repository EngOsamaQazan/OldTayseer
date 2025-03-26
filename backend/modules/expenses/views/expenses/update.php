<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Expenses */
$this->title = Yii::t('app', 'Update Expense');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Expenses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="expenses-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
