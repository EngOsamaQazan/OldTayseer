<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use backend\modules\contractInstallment\models\ContractInstallment;
use backend\modules\contracts\models\Contracts;
use kartik\date\DatePicker;
use yii\bootstrap\ButtonDropdown;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FollowUpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Follow Ups');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="follow-up-index box box-primary box-primary">
    <?=
    $this->render('_form', [
        'modelsPhoneNumbersFollwUps' => $modelsPhoneNumbersFollwUps,
        'contract_model' => $contract_model,
        'contract_id' => $contract_id,
        'model' => $model
    ])
    ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);    
    ?>
</div>
<div class="follow-up-index box box-primary box-primary">
    <h3><?= Yii::t('app', 'متابعات سابقة') ?></h3>
    <div class="row">

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => '',
            'columns' => [
                'date_time',
                [
                    'attribute' => 'notes',
                    'contentOptions' =>
                    ['style' => 'white-space:pre-line;direction: rtl'],
                ],
                'promise_to_pay_at',
                'reminder',
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'created_by',
                    'value' => function ($model) {
                        if (isset($model->createdBy->username)) {
                            return $model->createdBy->username;
                        }
                    }
                ],
                [
                    'attribute' => 'feeling',
                    'value' => function ($model) {
                        return Yii::t('app', $model->feeling);
                    }
                ],
                //'created_by',
                //'connection_goal',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => Yii::t('app', 'Actions'),
                    'template' => '{view}{update}',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-eye-open"></span>',
                                ['view', 'id' => $key, 'contract_id' => $model->contract_id],
                                ['title' => 'view', 'data-pjax' => '0']
                            );
                        },
                        'update' => function ($url, $model, $key) {
                            $date = new DateTime($model->date_time);
                            $now = new DateTime();

                            if ($model->created_by == Yii::$app->user->id && $date->diff($now)->format("%d") < 1) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $key, 'contract_id' => $model->contract_id], ['title' => 'update', 'data-pjax' => '0']);
                            }
                        },
                    ],
                ]
            ],
        ]);
        ?>

    </div>
</div>

<?php
if (!($contract_model->status == 'judiciary' || $contract_model->status == 'legal_department')) {
?>
    <div class="follow-up-index box box-primary box-primary convert-to-legal">
        <legend>
            <h3><?= Yii::t('app', 'التحويل للدائرة القانونية') ?></h3>
        </legend>
        <div class="row">
            <div class="col-sm-2 col-xs-2">
                <?php
                echo Html::a(Yii::t('app', 'تحويل'), ['/contracts/contracts/to-legal-department', 'id' => $contract_id], ['class' => 'btn btn-success']);
                ?>
            </div>
        </div>
    </div>
<?php
}
?>

<div class="follow-up-index box box-primary box-primary ">
    <legend>
        <h3><?= Yii::t('app', 'طلب مراجعة المدير') ?></h3>
    </legend>
    <div class="row">
        <div class="col-sm-2 col-xs-2">
            <?php
            echo Html::a(Yii::t('app', 'طلب'), ['/contracts/contracts/convert-to-manager', 'id' => $contract_id], ['class' => 'btn btn-success']);
            ?>
        </div>
    </div>
</div>
<?= $this->render('partial/next_contract.php', ['model' => $model, 'contract_id' => $contract_id]); ?>
<?php
$contractStatus = !empty($contract_model->status) ? $contract_model->status : '';
$this->registerJs(
    <<<SICRIPT
$(window).on('load',function(){
if('$contractStatus' == 'judiciary' || '$contractStatus' == 'legal_department'){
$('.convert-to-legal').hide();
}else{
$('.convert-to-legal').show();
}
})
SICRIPT
)
?>