<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;

return [
    /* [
         'class' => 'kartik\grid\SerialColumn',
         'width' => '30px',
     ],*/
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'name',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'primary_phone_number',
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_number',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'مشتكى عليه',
        'value'=>function($model){
        $yes_or_no = \backend\modules\judiciary\models\Judiciary::find()
            ->innerJoin('os_contracts_customers','os_judiciary.contract_id = os_contracts_customers.contract_id')
            ->where('os_contracts_customers.customer_id ='.$model->id)->all();

        if(!empty($yes_or_no)){
            return 'نعم';
        }else{
            return 'لا';
        }
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'العقود',
        'attribute' => 'contract',
        'value'=>function($model){
            $contracts_id =  \backend\modules\customers\models\ContractsCustomers::find()->where(['customer_id'=>$model->id])->all();
            $all_contract = "";
            foreach ($contracts_id as $contract_id){
                $contractUrl = Html::a(
                    " {" . $contract_id->contract_id . "} ",  \yii\helpers\Url::to(['/followUp/follow-up/index', 'contract_id' => $contract_id->contract_id]), [
                        'class' => 'link-class',
                        'title' => 'عرض متابعة العقد',
                        'data-pjax' => '0',
                    ]
                );
                $all_contract = $all_contract . $contractUrl;
            }
        return $all_contract;
        },
        'format' => 'raw',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'job_title',
        'value'=>'jobs.name'
    ],
    ['class' => 'yii\grid\ActionColumn',
        'contentOptions' => ['style' => 'width:10%;'],
        'header' => Yii::t('app', 'Actions'),
        'template' => '{all}',
        'buttons' => [
            'all' => function ($url, $model, $key) {
                return ButtonDropdown::widget([
                    'encodeLabel' => false, // if you're going to use html on the button label
                    'label' => Yii::t('app', 'Actions'),
                    'dropdown' => [
                        'encodeLabels' => false, // if you're going to use html on the items' labels
                        'items' => [
                            [
                                'label' => '<i class="icon-pencil5"></i>' . \Yii::t('app', 'Update'),
                                'url' => ['update', 'id' => $model->id],
                                'visible' => true,
                            ],
                            [
                                'label' => ' <i class="icon-list"></i>' . \Yii::t('app', 'إضافة عقد'),
                                'linkOptions' => [
                                    'data' => [
                                        'method' => 'post'
                                    ],
                                ],
                                'url' => ['/contracts/contracts/create', 'id' => $model->id],
                                'visible' => true, // if you want to hide an item based on a condition, use this
                            ],
                            [
                                'label' => '<i class="icon-bin"></i>' . \Yii::t('app', 'Delete'),
                                'linkOptions' => [
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => '<i class="icon-bin"></i>' . \Yii::t('yii', 'are you sure you want to delete ?'),
                                    ],
                                ],
                                'url' => ['delete', 'id' => $model->id],
                                'visible' => true, // same as above
                            ],
                        ],
                        'options' => [
                            'class' => 'dropdown-menu-right', // right dropdown
                        ],
                    ],
                    'options' => [
                        'class' => 'btn-default',
                        'style' => 'padding-left: 5px; padding-right: 5px;', // btn-success, btn-info, et cetera
                    ],
                    'split' => true, // if you want a split button
                ]);
            },
        ],
//            [
//                'class' => 'kartik\grid\ActionColumn',
//                'dropdown' => true,
//                'vAlign' => 'middle',
//                'urlCreator' => function($action, $model, $model->id, $index) {
//                    return Url::to([$action, 'id' => $model->id]);
//                },
//                        'viewOptions' => ['role' => 'modal-remote', 'title' => 'View', 'data-toggle' => 'tooltip'],
//                        'updateOptions' => ['role' => 'modal-remote', 'title' => 'Update', 'data-toggle' => 'tooltip'],
//                        'deleteOptions' => ['role' => 'modal-remote', 'title' => 'Delete',
//                            'data-confirm' => false, 'data-method' => false, // for overide yii data api
//                            'data-request-method' => 'post',
//                            'data-toggle' => 'tooltip',
//                            'data-confirm-title' => 'Are you sure?',
//                            'data-confirm-message' => 'Are you sure want to delete this item'],
//                    ]
    ]];
        