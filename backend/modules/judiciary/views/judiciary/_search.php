<?php

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\judiciaryType\models\JudiciaryType;
use backend\modules\court\models\Court;
use backend\modules\lawyers\models\Lawyers;
use kartik\date\DatePicker;
$judiciaryType  =   Yii::$app->cache->getOrSet(Yii::$app->params["key_judiciary_type"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['judiciary_type_query'])->queryAll();
}, Yii::$app->params['time_duration']);

$lawyer  =   Yii::$app->cache->getOrSet(Yii::$app->params["key_lawyer"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['lawyer_query'])->queryAll();
}, Yii::$app->params['time_duration']);

$job_title  =   Yii::$app->cache->getOrSet(Yii::$app->params["key_job_title"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['job_title_query'])->queryAll();
}, Yii::$app->params['time_duration']);

$jobs_type  =   Yii::$app->cache->getOrSet(Yii::$app->params["key_jobs_type"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['jobs_type_query'])->queryAll();
}, Yii::$app->params['time_duration']);

$judiciary_actions  =   Yii::$app->cache->getOrSet(Yii::$app->params["key_judiciary_actions"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['judiciary_actions_query'])->queryAll();
}, Yii::$app->params['time_duration']);

$court  =   Yii::$app->cache->getOrSet(Yii::$app->params["key_court"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['court_query'])->queryAll();
}, Yii::$app->params['time_duration']);

/* @var $model */
?>
    <div class="questions-bank box box-primary">

        <?php
        $form = yii\widgets\ActiveForm::begin([
            'id' => '_search',
            'method' => 'get',
            'action' => ['index']
        ]);
        ?>
        <div class="row">
            <div class="col-lg-6">
                <?=
                $form->field($model, 'court_id')->widget(kartik\select2\Select2::class, [
                    'data' => yii\helpers\ArrayHelper::map($court, 'id', 'name'),
                    'language' => 'de',
                    'options' => [
                        'placeholder' => 'Select a court.',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
            <div class="col-lg-6">
                <?=
                $form->field($model, 'type_id')->widget(kartik\select2\Select2::class, [
                    'data' => yii\helpers\ArrayHelper::map($judiciaryType, 'id', 'name'),
                    'language' => 'de',
                    'options' => [
                        'placeholder' => 'Select a type.',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <?=
                $form->field($model, 'lawyer_id')->widget(kartik\select2\Select2::class, [
                    'data' => yii\helpers\ArrayHelper::map($lawyer, 'id', 'name'),
                    'language' => 'de',
                    'options' => [
                        'placeholder' => 'Select a lawyer.',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'lawyer_cost')->textInput() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <?= $form->field($model, 'case_cost')->textInput() ?>

            </div>
            <div class="col-lg-6">
            <?= $form->field($model, 'contract_id')->textInput(['maxlength' => true]) ?>
                <?php
                //echo
                // $form->field($model, 'contract_id')->widget(kartik\select2\Select2::class, [
                //     'data' => yii\helpers\ArrayHelper::map(\backend\modules\judiciary\models\Judiciary::find()->all(), 'contract_id', 'contract_id'),
                //     'language' => 'de',
                //     'options' => [
                //         'placeholder' => 'Select a lawyer.',
                //     ],
                //     'pluginOptions' => [
                //         'allowClear' => true
                //     ],
                // ])->label(Yii::t('app', 'Contract ID'));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <?=
                $form->field($model, 'from_income_date')->widget(DatePicker::class, ['pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]])->label(Yii::t('app', 'من تاريخ الورود'));
                ?>

            </div>
            <div class="col-lg-6">
                <?=
                $form->field($model, 'to_income_date')->widget(DatePicker::class, ['pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]])->label(Yii::t('app', 'الى تاريخ الورود'));
                ?>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <?= $form->field($model, 'year')->widget(kartik\select2\Select2::class, [
                    'data' => $model->year(),
                    'language' => 'de',
                    'options' => [
                        'placeholder' => 'Select a year.',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(Yii::t('app', 'Year'));

                ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'judiciary_number')->textInput()->label(Yii::t('app', 'Judiciary Number')); ?>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <?= $form->field($model, 'number_row')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'job_title')->widget(kartik\select2\Select2::class, [
                    'data' => ArrayHelper::map($job_title ,'id','name'),
                    'language' => 'de',
                    'options' => [
                        'placeholder' => 'Select a year.',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);

                ?>
            </div>
            <div class="col-lg-6">
            <?php
            $active = backend\modules\judiciary\models\Judiciary::ACTIVE;
            $finished = backend\modules\judiciary\models\Judiciary::FINISHED;
            $form->field($model, 'contract_not_in_status')->dropDownList([ 'finished' =>$finished ,'active' =>$active]);
            ?>
        </div>
        </div>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'jobs_type')->widget(kartik\select2\Select2::class, [
                'data' => ArrayHelper::map($jobs_type ,'id','name'),
                'language' => 'de',
                'options' => [
                    'placeholder' => 'Select a year.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);

            ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'status')->widget(kartik\select2\Select2::class, [
                'data' => ['Available'=>Yii::t('app','Available '),'unAvailable'=>Yii::t('app','unAvailable '),'all'=>Yii::t('app','all')],
                'language' => 'de',
                'options' => [
                    'placeholder' => 'Select a year.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);

            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'judiciary_actions')->widget(kartik\select2\Select2::class, [
                'data' => ArrayHelper::map($judiciary_actions ,'id','name'),
                'language' => 'de',
                'options' => [
                    'placeholder' => 'Select a year.',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'multiple' => true,
                ],
            ]);

            ?>
        </div>
    </div>

        <div class="form-group">
            <?= yii\helpers\Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php yii\widgets\ActiveForm::end() ?>