<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\contractsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contracts');
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
?>
<div class="contracts-index">
    <?= $this->render('_search', ['model' => $searchModel]); ?>
    <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message): ?>
        <div class="alert alert-<?= $key ?>">
            <?= $message[0] ?>
        </div>
    <?php endforeach; ?>
    <div id="ajaxCrudDatatable">
        <?=
        GridView::widget([
            'id' => 'crud-datatable',
            'dataProvider' => $dataProvider,
            'summary' => false,
            'pjax' => true,
            'columns' => require(__DIR__ . '/_columns.php'),
            'toolbar' => [
                ['content' =>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['title' => Yii::t('app', 'Create new Contracts'), 'class' => 'btn btn-default']) .
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''], ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => 'Reset Grid']) .
                    '{toggleData}' .
                    '{export}'
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'heading' => Yii::t('app', 'The total of counteract') . ':' . $dataCount,
            ]
        ])
        ?>

    </div>
</div>
<?php
Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "", // always need it for jquery plugin
])
?>
<?php Modal::end(); ?>
<?php
$this->registerJs(<<<SCRIPT
$(document).on('change','.followUpUser',function(){
let id = $(this).attr('data-id');
let followedBy = $(this).val();
$.post('contracts/chang-follow-up',{id:id,followedBy:followedBy},function(as){
})
});
SCRIPT
)
?>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body"  style="text-align: right ;font-size: 20px">
               هل انت متاكد من حذف هذا العقد
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary " data-dismiss="modal">لا</button>
                <button type="button" class="btn btn-danger yeas-finish">نعم</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="123" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body" style="text-align: right ;font-size: 20px">
                هل انت متاكد من الغاء هذا العقد
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary " data-dismiss="modal">لا</button>
                <button type="button" class="btn btn-danger yeas-cancel">نعم</button>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJs(<<<SCRIPT
$(document).on('click','.yeas-finish',function(){

})
$(document).on('click','.yeas-finish',function(){

   let contract_id = $('.finish').attr('data-id');
   $.post('finish',{contract_id:contract_id},function(response){
   location.load();
   });
 
});

$(document).on('click','.yeas-cancel',function(){
   let contract_id = $('.cancel').attr('data-id');
   $.post('cancel',{contract_id:contract_id},function(response){
   location.load();
   });
 
});
SCRIPT
)
?>
