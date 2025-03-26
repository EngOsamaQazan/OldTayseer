<?php
use yii\helpers\Url;
use yii\bootstrap\ButtonDropdown;
use common\helper\LoanContract;
return [
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'id',
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'category_id',
        'value' => 'category.name'
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'created_at',
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'created_by',
        'value' => 'createdBy.username'
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'updated_at',
    // ],
    //  [
    //    'class'=>'\kartik\grid\DataColumn',
    //  'attribute'=>'last_updated_by',
    //],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'description',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'amount',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'receiver_number',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'expenses_date',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'notes',
        'label' => Yii::t('app', 'Notes'),
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'document_number',
        'label' => Yii::t('app', 'Document Number'),
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'contract_id',
    ],

    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'financial_transaction_id',
    // ],
    ['class' => 'yii\grid\ActionColumn',
        'contentOptions' => ['style' => 'width:10%;'],
        'header' => Yii::t('app', 'Actions'),
        'template' => '{all}',
        'buttons' => [
            'all' => function ($url, $model, $key) {
                if(!empty($model->financial_transaction_id)){
                    return ButtonDropdown::widget([
                        'encodeLabel' => false, // if you're going to use html on the button label
                        'label' => Yii::t('app', 'Actions'),
                        'dropdown' => [
                            'encodeLabels' => false, // if you're going to use html on the items' labels
                            'items' => [
                                [
                                    'label' => '<i class="icon-pencil5"></i>' . \Yii::t('app', 'Update'),
                                    'url' => ['update', 'id' => $key],
                                    'visible' => true,
                                ],
//                                            [
//                                                'label' => \Yii::t('yii', '<i class="icon-list"></i> validate'),
//                                                'url' => ['validate', 'id' => $key],
//                                                'visible' => true, // if you want to hide an item based on a condition, use this
//                                            ],
                                [
                                    'label' => '<i class="icon-pencil5"></i>' . \Yii::t('app', 'delete'),
                                    'url' => ['delete', 'id' => $key],
                                    'visible' => true,
                                ],
                                [
                                    'label' => '<i class="icon-pencil5"></i>' . \Yii::t('app', 'view'),
                                    'url' => ['view', 'id' => $key],
                                    'visible' => true,
                                ],
                                [
                                    'label' => '<i class="icon-pencil5"></i>' . \Yii::t('app', 'Back to financial transaction'),
                                    'url' => ['back-to-financial-transaction', 'id' => $key,'financial'=>$model->financial_transaction_id],
                                    'visible' => true,
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
                }else{
                    return ButtonDropdown::widget([
                        'encodeLabel' => false, // if you're going to use html on the button label
                        'label' => Yii::t('app', 'Actions'),
                        'dropdown' => [
                            'encodeLabels' => false, // if you're going to use html on the items' labels
                            'items' => [
                                [
                                    'label' => '<i class="icon-pencil5"></i>' . \Yii::t('app', 'Update'),
                                    'url' => ['update', 'id' => $key],
                                    'visible' => true,
                                ],
//                                            [
//                                                'label' => \Yii::t('yii', '<i class="icon-list"></i> validate'),
//                                                'url' => ['validate', 'id' => $key],
//                                                'visible' => true, // if you want to hide an item based on a condition, use this
//                                            ],
                                [
                                    'label' => '<i class="icon-pencil5"></i>' . \Yii::t('app', 'delete'),
                                    'url' => ['delete', 'id' => $key],
                                    'visible' => true,
                                ],
                                [
                                    'label' => '<i class="icon-pencil5"></i>' . \Yii::t('app', 'view'),
                                    'url' => ['view', 'id' => $key],
                                    'visible' => true,
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
                }

            },
        ],
    ]

];