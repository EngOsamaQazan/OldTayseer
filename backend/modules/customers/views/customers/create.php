<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\Organization */

$this->title = Yii::t('app', 'Create New Customers');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="organization-create">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="col-md-5 col-sm-4 padding-r-0 padding-l-0" style="font-weight: 400; font-size:22px"
                title="<?= Yii::t('app', 'Back To Customers List') ?>">
                    <?= Html::a('<span class="glyphicon glyphicon glyphicon-step-backward" aria-hidden="true"></span> ' . Yii::t('app', 'Back To Customers List'), Url::to(['/customers/index'])) ?>
            </h3>
        </div>
        <div class="box-body">
            <?=
            $this->render('_form', [
                'model' => $model,
                'modelsAddress' => $modelsAddress,
                'modelsPhoneNumbers' => $modelsPhoneNumbers,
                'customerDocumentsModel' => $customerDocumentsModel,
                'modelRealEstate' => $modelRealEstate,
            ])
            ?>
        </div>
    </div>
</div>