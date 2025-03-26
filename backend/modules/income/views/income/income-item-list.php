<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\installment\models\IncomeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $totalAmount */

$this->title = Yii::t('app', 'Installments');
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
?>

<?=$this->render('_income-list-search',[
    'model'=>$searchModel
])?>

<div class="installment-index>
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'summary'=>'',
            'pjax'=>true,
            'columns' => require(__DIR__ . '/_income-list-columns.php'),
            'toolbar'=> [
                ['content'=>
                /*Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                ['role'=>'modal-remote','title'=> 'Create new Installments','class'=>'btn btn-default']).*/
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                        ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    '{toggleData}'.
                    '{export}'
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'type' => 'default',
                'heading'=>'<h4>'.Yii::t('app','Total Amount').":{$totalAmount}</h4>",
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
