<?

use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use backend\modules\expenseCategories\models\ExpenseCategories;
use backend\modules\contracts\models\Contracts;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\modules\financialTransaction\models\FinancialTransaction;
use yii\helpers\Html;
use kartik\date\DatePicker;

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
            $form->field($model, 'type')->widget(kartik\select2\Select2::classname(), [
                'data' => ['', Yii::t('app', 'Income'), Yii::t('app', 'Outcome')],
                'language' => 'de',
                'options' => [
                    'placeholder' => 'Select a type.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(Yii::t('app','Type'));
            ?>
        </div>
        <div class="col-lg-6">

            <?=
            $form->field($model, 'Restriction')->widget(kartik\select2\Select2::classname(), [
                'data' => ['', Yii::t('app', 'restricted'), Yii::t('app', 'Unbound')],
                'language' => 'de',
                'options' => [
                    'placeholder' => 'Select a Restriction.',
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
            $form->field($model, 'created_by')->widget(kartik\select2\Select2::classname(), [
                'data' =>yii\helpers\ArrayHelper::map(Yii::$app->cache->getOrSet(Yii::$app->params["key_users"], function () {
                    return Yii::$app->db->createCommand(Yii::$app->params['users_query'])->queryAll();
                }, Yii::$app->params['time_duration']), 'id', 'username'),
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
        <div class="col-lg-6 ">
            <?=
            $form->field($model, 'company_id')->widget(kartik\select2\Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map(Yii::$app->cache->getOrSet(Yii::$app->params["key_company"], function () {
                    return Yii::$app->db->createCommand(Yii::$app->params['company_query'])->queryAll();
                }, Yii::$app->params['time_duration']), 'id', 'name'),
                'language' => 'de',
                'options' => [
                    'placeholder' => 'Select a company.',
                    'class' => 'type'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(Yii::t('app','Company Id'));
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?=
            $form->field($model, 'document_number')->widget(kartik\select2\Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map(Yii::$app->cache->getOrSet(Yii::$app->params["key_document_number"], function () {
                    return Yii::$app->db->createCommand(Yii::$app->params['document_number_query'])->queryAll();
                }, Yii::$app->params['time_duration']), 'document_number', 'document_number') ,

                'options' => [
                    'placeholder' => 'Select a document number.',
                    'class' => 'type'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-lg-6">
            <?=
            $form->field($model, 'created_at')->widget(kartik\select2\Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map(\common\models\User::find()->all(), 'created_at', function ($date) {
                    $updatedTime = $date->created_at;
                    return date('Y-m-d', $updatedTime);
                }),
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
        $form->field($model, 'date')->widget(\kartik\date\DatePicker::classname(), ['pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]]);
        ?>
    </div>
    <div class="col-lg-6">
        <?= $form->field($model, 'number_row')->textInput(['maxlength' => true]) ?>
    </div>
</div>
    <div class="form-group">
        <?= yii\helpers\Html::submitButton(Yii::t('app', 'بحث'), ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php yii\widgets\ActiveForm::end() ?>