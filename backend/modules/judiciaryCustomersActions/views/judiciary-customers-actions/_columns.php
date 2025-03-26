<?php

use yii\helpers\Url;

return [
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'judiciary_id',
        'value' => function ($model) {
         
            return $model->judiciary->judiciary_number . '/' . $model->judiciary->year;
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'اسم المحكوم عليه ',
        'value' => 'customers.name'
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'judiciary_actions_id',
        'value' => 'judiciaryActions.name',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'note',
        'width' => '30%',
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'updated_at',
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'created_by',
        'value' => 'createdBy.username'
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'اسم الوكيل',
        'value' => function ($model) {
            return \common\helper\FindJudicary::findLawyerJudicary($model->judiciary_id);
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'اسم المحكمة',
        'value' => function ($model) {
            return \common\helper\FindJudicary::findCourtJudicary($model->judiciary_id);
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'contract_id',

        'value' => function ($model) {
            return \common\helper\FindJudicary::findJudiciaryContract($model->judiciary_id);
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'action_date',
        'label' => ' تاريخ الاجراء'
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'is_deleted',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign' => 'middle',
        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $key]);
        },
        'viewOptions' => ['title' => 'View', 'data-toggle' => 'tooltip'],
        'updateOptions' => ['title' => 'Update', 'data-toggle' => 'tooltip'],
        'deleteOptions' => ['title' => 'Delete',
            'data-confirm' => false, 'data-method' => false,// for overide yii data api
            'data-request-method' => 'post',
            'data-toggle' => 'tooltip',
            'data-confirm-title' => 'Are you sure?',
            'data-confirm-message' => 'Are you sure want to delete this item'],
    ],
];