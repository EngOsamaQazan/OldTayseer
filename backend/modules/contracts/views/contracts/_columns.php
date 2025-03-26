<?php

use yii\helpers\Url;
use yii\bootstrap\ButtonDropdown;
use common\helper\LoanContract;
use backend\modules\contractInstallment\models\ContractInstallment;
use backend\modules\followUp\helper\ContractCalculations;
use common\helper\Permissions;
return [
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'seller_id',
        'value' => function ($model) {
            return (isset($model->seller->name)) ? $model->seller->name : null;
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'customer_name',
        'label' => Yii::t('app', 'Customer Name'),
        'value' => function ($model) {
            return join(', ', yii\helpers\ArrayHelper::map($model->customers, 'id', 'name'));
        },
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => Yii::t('app', 'المستحق'),
        'label' => Yii::t('app', 'المستحق'),
        'value' => function ($model) {
            $contractCalculations = new ContractCalculations($model->id);
            return $contractCalculations->deservedAmount();
        },
    ],
    /* [
      'class' => '\kartik\grid\DataColumn',
      'attribute' => 'customer_phone_number',
      'label' => Yii::t('app', 'Customer Phone Number'),
      'value' => function ($model) {
      return join(', ', yii\helpers\ArrayHelper::map($model->customers, 'id', 'primary_phone_number'));
      },
      ],
      [
      'class' => '\kartik\grid\DataColumn',
      'attribute' => 'guarantor_name',
      'label' => Yii::t('app', 'guarantor Name'),
      'value' => function ($model) {
      return join(', ', yii\helpers\ArrayHelper::map($model->customersGuarantor, 'id', 'name'));
      },
      ],
      [
      'class' => '\kartik\grid\DataColumn',
      'attribute' => 'guarantor_phone_number',
      'label' => Yii::t('app', 'guarantor Phone Number'),
      'value' => function ($model) {
      return join(', ', yii\helpers\ArrayHelper::map($model->customersGuarantor, 'id', 'primary_phone_number'));
      },
      ],*/
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'Date_of_sale',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'total_value',
        'value' => function ($model) {
            $totle_value = new LoanContract();
            $totle_value = $totle_value->findContract($model->id);
            if ($totle_value->status == 'judiciary') {
                if ($totle_value->is_loan == 1) {
                    $cost = \backend\modules\judiciary\models\Judiciary::find()->where(['contract_id' => $totle_value->id])->where(['>=', 'created_at', $totle_value->created_at])->orderBy(['contract_id' => SORT_DESC])->one();
                } else {
                    $cost = \backend\modules\judiciary\models\Judiciary::find()->where(['contract_id' => $totle_value->id])->orderBy(['contract_id' => SORT_DESC])->one();
                }
                if (!empty($cost)) {
                    $totle_value = $totle_value->total_value + $cost->case_cost + $cost->lawyer_cost;
                    return $totle_value;
                }
                return $totle_value->total_value;
            }
            return $totle_value->total_value;
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'first_installment_value',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'status',
        'label' => Yii::t('app', 'Status'),
        'value' => function ($model) {
            return Yii::t('app', $model->status);
        }
    ],
    /*[
        'class' => '\kartik\grid\DataColumn',
        'attribute' => Yii::t('app', 'Deserved Amount'),
        'label' => Yii::t('app', 'Status'),
        'value' => function ($model) {
            $contractCalculations = new ContractCalculations($model->id);
            return  $contractCalculations->deservedAmount();
        }
    ],*/
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => Yii::t('app', 'Residual Amount'),
        'value' => function ($model) {
            $judicary_contract = \backend\modules\judiciary\models\Judiciary::find()->where(['contract_id' => $model->id])->all();

            if (!empty($judicary_contract)) {
                $all_case_cost = \backend\modules\expenses\models\Expenses::find()->where(['contract_id' => $model->id])->andWhere(['category_id' => 4])->all();
                $sum_case_cost = 0;
                foreach ($all_case_cost as $case_cost) {
                    $sum_case_cost = $sum_case_cost + $case_cost->amount;

                }
            }
            if (!empty($judicary_contract)) {
                $cost = \backend\modules\judiciary\models\Judiciary::find()->where(['contract_id' => $model->id])->all();

                foreach ($cost as $cost) {
                    $totle_value = $model->total_value + $sum_case_cost + $cost->lawyer_cost;
                    $model->total_value = $totle_value;
                }
            }

            $paid_amount = ContractInstallment::find()
                ->andWhere(['contract_id' => $model->id])
                ->sum('amount');

            $paid_amount = ($paid_amount > 0) ? $paid_amount : 0;
            $custamer_referance = (empty($custamer_referance)) ? 0 : $custamer_referance;


            return  ($model->total_value + $custamer_referance) - $paid_amount;


        },
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'followed_by',
        'value' => function ($model) {
            $db = Yii::$app->db;

            if (Yii::$app->user->can(Permissions::MANAGER)) {

                $users = $db->cache(function ($db) {

                    return \common\models\User::find()->all();
                });
                return \yii\helpers\Html::a(\yii\helpers\Html::dropDownList('followedBy', $model->followed_by, \yii\helpers\ArrayHelper::map($users, 'id', 'username'), ['class' => ' followUpUser', 'data-id' => $model->id, 'prompt' => 'Select a user.']));
            }
                $users = $db->cache(function ($db) use ($model) {
                  $userinfo =   \common\models\User::findOne(['id' => $model->followed_by]);
                    return $userinfo->username;
                });
             return   $users;


        },
        'format' => 'raw',
    ],
    /*  [
      'class' => '\kartik\grid\DataColumn',
      'attribute' => 'followed_by',
      'value' => 'followedBy.username'
      ], */

// [
// 'class'=>'\kartik\grid\DataColumn',
// 'attribute'=>'monthly_installment_value',
// ],
// [
// 'class'=>'\kartik\grid\DataColumn',
// 'attribute'=>'notes',
// ],
// [
// 'class'=>'\kartik\grid\DataColumn',
// 'attribute'=>'updated_at',
// ],
// [
// 'class'=>'\kartik\grid\DataColumn',
// 'attribute'=>'is_deleted','pending','active','reconciliation','judiciary','canceled','refused','legal_department','finished','settlement'
// ],
    ['class' => 'yii\grid\ActionColumn',
        'contentOptions' => ['style' => 'width:10%;'],
        'header' => Yii::t('app', 'Actions'),
        'template' => '{all}',
        'buttons' => [
            'all' => function ($url, $model, $key) {
        if($model->status == 'judiciary'){
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
                            'label' => '<i class="icon-pencil5"></i>' . \Yii::t('app', 'Print Contract'),
                            'url' => ['print-first-page', 'id' => $key],
                            'visible' => true,
                        ],
                        [
                            'label' => '<i class="icon-pencil5"></i>' . \Yii::t('app', 'Print Draft'),
                            'url' => ['print-second-page', 'id' => $key],
                            'visible' => true,
                        ],
                        [
                            'label' => '<i class="icon-pencil5"></i>' . \Yii::t('app', 'Add Installment'),
                            'url' => ['/contractInstallment/contract-installment', 'contract_id' => $key],
                            'visible' => true,
                        ],
                        [
                            'label' => '<i class="icon-pencil5"></i>' . \Yii::t('app', 'Add Follow Up'),
                            'url' => ['/followUp/follow-up', 'contract_id' => $key],
                            'visible' => true,
                        ],
                        [
                            'label' => '<i class="icon-pencil5"></i>' . \Yii::t('app', 'Loan Scheduling'),
                            'url' => ['/loanScheduling/loan-scheduling/create', 'contract_id' => $key],
                            'visible' => true,
                        ],
                        [
                            'label' => '<i class="icon-pencil5"></i>' . \Yii::t('app', 'Collection'),
                            'url' => ['/collection/collection/create', 'contract_id' => $key],
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
                            'label' => '<i class="icon-pencil5"></i>' . \Yii::t('app', 'Print Contract'),
                            'url' => ['print-first-page', 'id' => $key],
                            'visible' => true,
                        ],
                        [
                            'label' => '<i class="icon-pencil5"></i>' . \Yii::t('app', 'Print Draft'),
                            'url' => ['print-second-page', 'id' => $key],
                            'visible' => true,
                        ],
                        [
                            'label' => '<i class="icon-pencil5"></i>' . \Yii::t('app', 'Add Installment'),
                            'url' => ['/contractInstallment/contract-installment', 'contract_id' => $key],
                            'visible' => true,
                        ],
                        [
                            'label' => '<i class="icon-pencil5"></i>' . \Yii::t('app', 'Add Follow Up'),
                            'url' => ['/followUp/follow-up', 'contract_id' => $key],
                            'visible' => true,
                        ],
                        [
                            'label' => '<i class="icon-pencil5"></i>' . \Yii::t('app', 'Loan Scheduling'),
                            'url' => ['/loanScheduling/loan-scheduling/create', 'contract_id' => $key],
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
        ]];
