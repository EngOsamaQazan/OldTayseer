<?

use yii\widgets\ActiveForm;
use \backend\modules\status\models\Status;
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
            <?=
            $form->field($model, 'first_installment_date')->widget(\kartik\date\DatePicker::classname(), ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]]);
            ?>
        </div>
        <div class="col-lg-6">
            <?=
            $form->field($model, 'contract_id')->widget(kartik\select2\Select2::classname(), [
                'data' =>yii\helpers\ArrayHelper::map(Yii::$app->cache->getOrSet(Yii::$app->params["key_contract_id"], function () {
                    return Yii::$app->db->createCommand(Yii::$app->params['contract_id_query'])->queryAll();
                }, Yii::$app->params['time_duration']), 'id', 'id'),
                'language' => 'de',
                'options' => [
                    'placeholder' => 'Select a contract.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'monthly_installment')->textInput() ?>
        </div>
        <div class="col-lg-6">
            <?=
            $form->field($model, 'last_update_by')->widget(kartik\select2\Select2::classname(), [
                'data' =>yii\helpers\ArrayHelper::map(Yii::$app->cache->getOrSet(Yii::$app->params["key_users"], function () {
                    return Yii::$app->db->createCommand(Yii::$app->params['users_query'])->queryAll();
                }, Yii::$app->params['time_duration']), 'id', 'username'),
                'language' => 'de',
                'options' => [
                    'placeholder' => 'Select a last updated by.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?=
            $form->field($model, 'status')->widget(\kartik\select2\Select2::classname(), [
                'data' =>yii\helpers\ArrayHelper::map(Yii::$app->cache->getOrSet(Yii::$app->params["key_status"], function () {
                    return Yii::$app->db->createCommand(Yii::$app->params['status_query'])->queryAll();
                }, Yii::$app->params['time_duration']), 'id', 'name'),
                'language' => 'de',
                'options' => ['placeholder' => 'Select a item.'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-lg-6">
            <?=
            $form->field($model, 'status_action_by')->widget(kartik\select2\Select2::classname(), [
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
                    'placeholder' => 'Select a created by.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'number_row')->textInput(['maxlength' => true]) ?>
        </div>


    </div>

    <div class="form-group">
        <?= yii\helpers\Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php yii\widgets\ActiveForm::end() ?>
</div>
