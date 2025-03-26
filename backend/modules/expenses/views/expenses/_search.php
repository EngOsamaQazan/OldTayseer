<?

use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
 use backend\modules\expenseCategories\models\ExpenseCategories;
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
        <div class="col-md-6">
            <?= $form->field($model, 'created_by')->widget(kartik\select2\Select2::classname(), [
                'data' =>yii\helpers\ArrayHelper::map( Yii::$app->cache->getOrSet(Yii::$app->params["key_users"], function () {
                    return Yii::$app->db->createCommand(Yii::$app->params['users_query'])->queryAll();
                }, Yii::$app->params['time_duration']), 'id', 'username'),
                'options' => [
                    'placeholder' => 'Select a created_by.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'receiver_number')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?=
            $form->field($model, 'date_from')->widget(\kartik\date\DatePicker::classname(), ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]])->label(Yii::t('app','Date From'));
            ?>
        </div>
        <div class="col-md-6">
            <?=
            $form->field($model, 'date_to')->widget(\kartik\date\DatePicker::classname(), ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]])->label(Yii::t('app','Date To'));
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'amount_from')->textInput()->label(Yii::t('app','Amount From'));
 ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'amount_to')->textInput()->label(Yii::t('app','Amount To')) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'category_id')->widget(kartik\select2\Select2::classname(), [
                'data' =>yii\helpers\ArrayHelper::map(  Yii::$app->cache->getOrSet(Yii::$app->params["key_expenses_category"], function () {
                    return Yii::$app->db->createCommand(Yii::$app->params['expenses_category_query'])->queryAll();
                }, Yii::$app->params['time_duration']), 'id', 'name'),
                'options' => [
                    'placeholder' => 'Select a category.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'contract_id')->widget(kartik\select2\Select2::classname(), [
                'data' =>yii\helpers\ArrayHelper::map( Yii::$app->cache->getOrSet(Yii::$app->params["key_expenses_contract"], function () {
                    return Yii::$app->db->createCommand(Yii::$app->params['income_category_query'])->queryAll();
                }, Yii::$app->params['time_duration']), 'contract_id', 'contract_id'),
                'options' => [
                    'placeholder' => 'Select a expenses.',
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
        <?= $form->field($model, 'number_row')->textInput(['maxlength' => true]) ?>
    </div>
</div>
    <div class="form-group">
        <?= yii\helpers\Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php yii\widgets\ActiveForm::end() ?>
</div>
