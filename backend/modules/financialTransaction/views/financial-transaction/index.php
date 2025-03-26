<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use backend\modules\expenseCategories\models\ExpenseCategories;
use backend\modules\contracts\models\Contracts;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use backend\modules\incomeCategory\models\IncomeCategory;
use backend\modules\financialTransaction\models\FinancialTransaction;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\ArrayHelper;
use mdm\admin\components\Helper;
use kartik\select2\Select2;
use common\helper\Permissions;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\financialTransaction\models\FinancialTransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $dataTransfer */
/* @var $dataTransferExpenses */

$this->title = Yii::t('app', 'Financial Transaction');
$this->params['breadcrumbs'][] = $this->title;
CrudAsset::register($this);
$customerPayments = FinancialTransaction::CUSTOMER_PAYMENTS;
$courtResponses = FinancialTransaction::COURT_RESPONSES;

?>

<?= $this->render('_search', ['model' => $searchModel]) ?>
<?php
if (Yii::$app->user->can(Permissions::FINANCIAL_TRANSACTION_TO_EXPORT_DATA)) {
    ?>
    <?= Html::a(Yii::t('app', 'استيراد  ملف'), Url::to(['financial-transaction/import-file']), ['class' => 'btn btn-primary', 'style' => "margin-top: 20px"]) ?>
    <?= Html::a(Yii::t('app', 'الترحيل الى الدفعات') . '  ' . $dataTransfer, Url::to(['financial-transaction/transfer-data']), ['class' => 'btn btn-primary', 'style' => "margin-top: 20px;margin-left:10px"]) ?>
    <?= Html::a(Yii::t('app', 'الترحيل الى المصاريف') . '  ' . $dataTransferExpenses, Url::to(['financial-transaction/transfer-data-to-expenses']), ['class' => 'btn btn-primary', 'style' => "margin-top: 20px;margin-left:10px"]) ?>
<?php } ?>
<div class="expenses-index" style="margin-top: 20px">
    <div id="ajaxCrudDatatable">
        <?php if (Yii::$app->user->can(Permissions::MANAGER)) { ?>
            <?= GridView::widget([
                'id' => 'crud-datatable',
                'dataProvider' => $dataProvider,
                'summary' => '',
                'columns' => [

                    // [
                    // 'class'=>'\kartik\grid\DataColumn',
                    // 'attribute'=>'id',
                    // ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'description',
                        'value' => function ($model) {
                            return !empty($model->description) ? $model->description : $model->bank_description;
                        },
                        'options' => [
                            'style' => 'width:30%'
                        ]
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'amount',
                        'options' => [
                            'style' => 'width:5%'
                        ]
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'type',
                        'value' => function ($model) {
                            // $type = ['', 'Income', 'Outcome'];
                            // return Html::dropDownList('type', $model->type, $type, ['class' => 'form-control type', 'data-id' => $model->id]);
                            return ($model->type == 1) ? "دفعات دائنه" : "دفعات مدينه";
                        },
                        //  'format' => 'raw',
                        // 'options' => [
                        //    'style' => 'width:15%',
                        //],
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'category_id',
                        'value' => function ($model) {
                            $categoryItems = Yii::$app->cache->getOrSet(Yii::$app->params["key_expenses_category"], function () {
                                return Yii::$app->db->createCommand(Yii::$app->params['expenses_category_query'])->queryAll();
                            }, Yii::$app->params['time_duration']);
                            $items = [];
                            foreach ($categoryItems as $categoryItem) {
                                $items [$categoryItem['id']] = $categoryItem['name'];
                            }
                          /*  if ($model->type == FinancialTransaction::TYPE_OUTCOME) {
                                return Select2::widget([
                                    'model' => $model,
                                    'attribute' => 'category_id',
                                    'value' => $model->category_id,
                                    'data' => $items,
                                    'options' => [
                                        'placeholder' => 'Select Zone ...',
                                        'class' => 'form-control category-change ',
                                        'data-id' => $model->id,
                                    ],
                                    'pluginOptions' => [
                                        'tags' => true,
                                    ],
                                ]);
                            } else {
                                return " ";
                            }
*/
                             return '<div class="category-list" style="display:' . ($model->type == FinancialTransaction::TYPE_OUTCOME ? 'block' : 'none') . ' ">' . Html::dropDownList('category_id', $model->category_id, $items, ['class' => 'form-control category-change', 'data-id' => $model->id, 'prompt' => 'Select a category.']) . '</div>';
                        },
                        'format' => 'raw',
                        'options' => [
                            'style' => 'width:10%',
                        ]
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'income_type',
                        'value' => function ($model) {
                            $types = Yii::$app->cache->getOrSet(Yii::$app->params["key_income_category"], function () {
                                return Yii::$app->db->createCommand(Yii::$app->params['income_category_query'])->queryAll();
                            }, Yii::$app->params['time_duration']);
                            $items = [];
                            foreach ($types as $type) {
                                $items [$type['id']] = $type['name'];
                            }

                            /*if ($model->type == FinancialTransaction::TYPE_INCOME) {
                                return Select2::widget([
                                    'model' => $model,
                                    'attribute' => 'income_type',
                                    'value' => $model->income_type,
                                    'data' => $items,
                                    'options' => [
                                        'placeholder' => 'Select Zone ...',
                                        'class' => 'form-control income_type',
                                        'data-id' => $model->id,
                                    ],
                                    'pluginOptions' => [
                                        'tags' => true,
                                    ],
                                ]);
                            } else {
                                return " ";
                            }
*/
                            return '<div class="income-type-list" style="display:' . ($model->type == FinancialTransaction::TYPE_INCOME ? 'block' : 'none') . ' ">' . Html::dropDownList('income_type', $model->income_type, $items, ['class' => 'form-control income_type', 'data-id' => $model->id]) . '</div>';

                        },
                        'format' => 'raw',
                        'options' => [
                            'style' => 'width:10%'
                        ]
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'contract_id',
                        'value' => function ($model) {

                            $contracts = Yii::$app->cache->getOrSet(Yii::$app->params["key_contract_id"], function () {
                                return Yii::$app->db->createCommand(Yii::$app->params['contract_id_query'])->queryAll();
                            }, Yii::$app->params['time_duration']);
                            $items = [];
                            foreach ($contracts as $contract) {
                                $items [$contract['id']] = $contract['id'];
                            }
                            $customerPayments = FinancialTransaction::CUSTOMER_PAYMENTS;
                            $courtResponses = FinancialTransaction::COURT_RESPONSES;
                         /*   if (($model->income_type == $customerPayments )||( $model->income_type == $courtResponses) || !empty($model->category_id)) {
                                return Select2::widget([
                                    'model' => $model,
                                    'attribute' => 'contract_id',
                                    'value' => $model->contract_id,
                                    'data' => $items,
                                    'options' => [
                                        'placeholder' => 'Select Zone ...',
                                        'class' => 'form-control contract',
                                        'data-id' => $model->id,
                                    ],
                                    'pluginOptions' => [
                                        'tags' => true,
                                    ],
                                ]);
                            } else {
                                return " ";
                            }*/
                            return '<div class="contract-id-list" style="display:' . ($model->income_type == 8 || $model->income_type == 11 || !empty($model->category_id) ? 'block' : 'none') . ' ">' . Html::dropDownList('contract_id', $model->contract_id, $items, ['class' => 'form-control contract', 'data-id' => $model->id, 'prompt' => 'Select a contract.']) . '</div>';
                        },
                        'format' => 'raw',
                        'options' => [
                            'style' => 'width:10%'
                        ],
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'company_id',
                        'label' => 'الشركة',
                        'value' => 'company.name',
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'date',
                        'options' => [
                            'style' => 'width:5%'
                        ]
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'document_number',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return '<input type="text" class="document_number" value = "' . $model->document_number . ' " data-id = "' . $model->id . ' " >';
                        },
                        'options' => [
                            'style' => 'width:10%'
                        ]

                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'notes',
                        'label' => 'الملاحضات',
                        'options' => [
                            'style' => 'width:5%',
                        ],
                        'value' => function ($model) {
                            if (!empty($model->bank_description)) {
                                return '<button type="button" class="btn btn-primary mtext"   data-id = "' . $model->id . ' " data-toggle="modal" data-target="#exampleModal">
الملاحضات
</button>';
                            } else {
                                return '';
                            }

                        },
                        'format' => 'raw',

                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'dropdown' => false,
                        'vAlign' => 'middle',
                        'template' => '{delete}',
                        'urlCreator' => function ($action, $model, $key, $index) {
                            return Url::to([$action, 'id' => $key]);
                        },
                        'deleteOptions' => ['title' => 'Delete',
                            'data-confirm' => false, 'data-method' => false, // for overide yii data api
                            'data-request-method' => 'post',
                            'data-toggle' => 'tooltip',
                            'data-confirm-title' => 'Are you sure?',
                            'data-confirm-message' => 'Are you sure want to delete this item'],
                    ],
                ],
                'toolbar' => [
                    ['content' =>
                        Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                            ['title' => 'Create new financial transaction', 'class' => 'btn btn-default']) .
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                            ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => 'Reset Grid']) .
                        '{toggleData}' .
                        '{export}'
                    ],
                ],
                'striped' => true,
                'condensed' => true,
                'responsive' => true,
                'panel' => [
                    'type' => 'default',
                ]
            ]) ?>
        <?php } else { ?>
            <?= GridView::widget([
                'id' => 'crud-datatable',
                'dataProvider' => $dataProvider,
                'summary' => '',
                'columns' => [

                    // [
                    // 'class'=>'\kartik\grid\DataColumn',
                    // 'attribute'=>'id',
                    // ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'description',
                        'value' => function ($model) {
                            return !empty($model->description) ? $model->description : $model->bank_description;
                        },
                        'options' => [
                            'style' => 'width:20%'
                        ]
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'amount',
                        'options' => [
                            'style' => 'width:5%'
                        ]
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'type',
                        'value' => function ($model) {
                            // $type = ['', 'Income', 'Outcome'];
                            // return Html::dropDownList('type', $model->type, $type, ['class' => 'form-control type', 'data-id' => $model->id]);
                            return ($model->type == 1) ? "دفعات دائنه" : "دفعات مدينه";
                        },
                        //  'format' => 'raw',
                        // 'options' => [
                        //    'style' => 'width:15%',
                        //],
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'category_id',
                        'value' => function ($model) {
                            $categoryItems = Yii::$app->cache->getOrSet(Yii::$app->params["key_expenses_category"], function () {
                                return Yii::$app->db->createCommand(Yii::$app->params['expenses_category_query'])->queryAll();
                            }, Yii::$app->params['time_duration']);
                            $items = [];
                            foreach ($categoryItems as $categoryItem) {
                                $items [$categoryItem['id']] = $categoryItem['name'];
                            }
                            if ($model->type == FinancialTransaction::TYPE_OUTCOME) {
                                return Select2::widget([
                                    'model' => $model,
                                    'attribute' => 'category_id',
                                    'value' => $model->category_id,
                                    'data' => $items,
                                    'options' => [
                                        'placeholder' => 'Select Zone ...',
                                        'class' => 'form-control category-change ',
                                        'data-id' => $model->id,
                                    ],
                                    'pluginOptions' => [
                                        'tags' => true,
                                    ],
                                ]);
                            } else {
                                return " ";
                            }

                            // return '<div class="category-list" style="display:' . ($model->type == FinancialTransaction::TYPE_OUTCOME ? 'block' : 'none') . ' ">' . Html::dropDownList('category_id', $model->category_id, $items, ['class' => 'form-control category-change', 'data-id' => $model->id, 'prompt' => 'Select a category.']) . '</div>';
                        },
                        'format' => 'raw',
                        'options' => [
                            'style' => 'width:10%',
                        ]
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'income_type',
                        'value' => function ($model) {
                            $types = Yii::$app->cache->getOrSet(Yii::$app->params["key_income_category"], function () {
                                return Yii::$app->db->createCommand(Yii::$app->params['income_category_query'])->queryAll();
                            }, Yii::$app->params['time_duration']);
                            $items = [];
                            foreach ($types as $type) {
                                $items [$type['id']] = $type['name'];
                            }

                            if ($model->type == FinancialTransaction::TYPE_INCOME) {
                                return Select2::widget([
                                    'model' => $model,
                                    'attribute' => 'income_type',
                                    'value' => $model->income_type,
                                    'data' => $items,
                                    'options' => [
                                        'placeholder' => 'Select Zone ...',
                                        'class' => 'form-control income_type',
                                        'data-id' => $model->id,
                                    ],
                                    'pluginOptions' => [
                                        'tags' => true,
                                    ],
                                ]);
                            } else {
                                return " ";
                            }

                            //return '<div class="income-type-list" style="display:' . ($model->type == FinancialTransaction::TYPE_INCOME ? 'block' : 'none') . ' ">' . Html::dropDownList('income_type', $model->income_type, $items, ['class' => 'form-control income_type', 'data-id' => $model->id]) . '</div>';

                        },
                        'format' => 'raw',
                        'options' => [
                            'style' => 'width:10%'
                        ]
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'contract_id',
                        'value' => function ($model) {

                            $contracts = Yii::$app->cache->getOrSet(Yii::$app->params["key_contract_id"], function () {
                                return Yii::$app->db->createCommand(Yii::$app->params['contract_id_query'])->queryAll();
                            }, Yii::$app->params['time_duration']);
                            $items = [];
                            foreach ($contracts as $contract) {
                                $items [$contract['id']] = $contract['id'];
                            }
                            $customerPayments = FinancialTransaction::CUSTOMER_PAYMENTS;
                            $courtResponses = FinancialTransaction::COURT_RESPONSES;
                            if ($model->income_type == $customerPayments || $model->income_type == $courtResponses|| !empty($model->category_id)) {
                                return Select2::widget([
                                    'model' => $model,
                                    'attribute' => 'contract_id',
                                    'value' => $model->contract_id,
                                    'data' => $items,
                                    'options' => [
                                        'placeholder' => 'Select Zone ...',
                                        'class' => 'form-control contract',
                                        'data-id' => $model->id,
                                    ],
                                    'pluginOptions' => [
                                        'tags' => true,
                                    ],
                                ]);
                            } else {
                                return " ";
                            }
                            //return '<div class="contract-id-list" style="display:' . ($model->income_type == 8 || $model->income_type == 11 || !empty($model->category_id) ? 'block' : 'none') . ' ">' . Html::dropDownList('contract_id', $model->contract_id, $items, ['class' => 'form-control contract', 'data-id' => $model->id, 'prompt' => 'Select a contract.']) . '</div>';
                        },
                        'format' => 'raw',
                        'options' => [
                            'style' => 'width:10%'
                        ],
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'company_id',
                        'label' => 'الشركة',
                        'value' => 'company.name',
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'date',
                        'options' => [
                            'style' => 'width:10%'
                        ]
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'document_number',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return '<input type="text" class="document_number" value = "' . $model->document_number . ' " data-id = "' . $model->id . ' " >';
                        },
                        'options' => [
                            'style' => 'width:10%'
                        ]

                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'notes',
                        'label' => 'الملاحضات',
                        'options' => [
                            'style' => 'width:15%',
                        ],
                        'value' => function ($model) {
                            if (!empty($model->bank_description)) {
                                return '<button type="button" class="btn btn-primary mtext"   data-id = "' . $model->id . ' " data-toggle="modal" data-target="#exampleModal">
الملاحضات
</button>';
                            } else {
                                return '';
                            }

                        },
                        'format' => 'raw',

                    ],

                ],

                'toolbar' => [
                    ['content' =>
                        Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                            ['title' => 'Create new financial transaction', 'class' => 'btn btn-default']) .
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                            ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => 'Reset Grid']) .
                        '{toggleData}' .
                        '{export}'
                    ],
                ],
                'striped' => true,
                'condensed' => true,
                'responsive' => true,
                'panel' => [
                    'type' => 'default',
                ]
            ]) ?>
        <?php } ?>
    </div>
</div>
<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "",// always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>
<?php

$typeIncome = FinancialTransaction::TYPE_INCOME;
$typeOutcome = FinancialTransaction::TYPE_OUTCOME;
$updateCategory = "  let newCategoryID = $(this).val();
        let expenseID = $(this).attr('data-id');
        
        $.post('" . yii\helpers\Url::to(['/financialTransaction/financial-transaction/update-category']) . "',{category_id:newCategoryID,id:expenseID},function(response){
        });";

$incomeType = "    let newTypeIncome = $(this).val();
        let expenseID = $(this).attr('data-id');
        
        $.post('" . yii\helpers\Url::to(['/financialTransaction/financial-transaction/update-type-income']) . "',{type_income:newTypeIncome,id:expenseID},function(response){
    
        });";
$contract = "  let contract = $(this).val();
        let expenseID = $(this).attr('data-id');
        $.post('" . yii\helpers\Url::to(['/financialTransaction/financial-transaction/contract']) . "',{contract:contract,id:expenseID},function(response){
       
        });";
$companies = " let company = $(this).val();
   let expenseID = $(this).attr('data-id');
   $.post('" . yii\helpers\Url::to(['/financialTransaction/financial-transaction/update-company']) . "',{company:company,id:expenseID},function(response){
    

   });
 ";
$document_number = "
   let number = $(this).val();
     let ID = $(this).attr('data-id');
     $.post('" . yii\helpers\Url::to(['/financialTransaction/financial-transaction/update-document']) . "',{number:number,id:ID},function(response){
   });
";
$updateType = " let newType = $(this).val();
        let expenseID = $(this).attr('data-id');
        $.post('" . yii\helpers\Url::to(['/financialTransaction/financial-transaction/update-type']) . "',{type:newType,id:expenseID},function(response){
         
        });";

$this->registerJs(<<<SCRIPT
    $(document).on('change','.category-change',function(){
    $updateCategory
    });
    $(document).on('change','.type',function(){
       $updateType
    });

    $(document).on('change','.type',function(){
        let typeVal = $(this).val();
            
        if(typeVal == $typeIncome){
            $(this).closest('tr').find('td').eq(4).find('.income-type-list').show();
            $(this).closest('tr').find('td').eq(3).find('.category-list').hide();
        } else if(typeVal == $typeOutcome){
            $(this).closest('tr').find('td').eq(4).find('.income-type-list').hide();
            $(this).closest('tr').find('td').eq(5).find('.contract-id-list').hide();
            $(this).closest('tr').find('td').eq(3).find('.category-list').show();
        }
    });   
       $(document).on('change','.income_type',function(){
         let incomeVal = $(this).val();
         if(incomeVal == 8 || incomeVal == 11){
          $(this).closest('tr').find('td').eq(5).find('.contract-id-list').show();
         }else if (incomeVal != $customerPayments || incomeVal == $courtResponses){
            $(this).closest('tr').find('td').eq(5).find('.contract-id-list').hide();

         }
       });
      $(document).on('change','.category-list',function(){
     
          $(this).closest('tr').find('td').eq(5).find('.contract-id-list').show();
       });
       
       
    $(document).on('change','.income_type',function(){
      $incomeType
    });

    $(document).on('change','.contract',function(){
      $contract
    });
$(document).on('change','.company',function(){
  $companies
});
  $(document).on('keyup','.document_number',function(){
$document_number
   });
SCRIPT
);
?>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Notes</h5>
            </div>
            <div class="modal-body">
                <input type="text" class="notes-text">
                <input type="hidden" class="idtext">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary save-changes">Save changes</button>
            </div>
        </div>
    </div>
</div>

<?php

$this->registerJs(<<<SCRIPT
$(document).on('click','.save-changes',function(){
let text = $('.notes-text').val();
let id = $('.idtext').val();
$.post('financial-transaction/save-notes',{text:text,id:id},function(as){
alert(as);
})
});
$(document).on('click','.mtext',function(){
$('.idtext').val( $(this).attr('data-id'));
let id = $('.idtext').val();
$.post('financial-transaction/find-notes',{id:id},function(as){
$('.notes-text').val(as);
})
})
SCRIPT
);
?>
<script>
    function myFunction() {

    }
</script>