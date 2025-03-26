<?

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use backend\modules\judiciary\models\Judiciary;
use backend\modules\customers\models\Customers;
use backend\modules\judiciaryActions\models\JudiciaryActions;
use yii\helpers\ArrayHelper;

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
            <?= $form->field($model, 'judiciary_id')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6">
            <?=
            $form->field($model, 'customers_id')->widget(kartik\select2\Select2::class, [
                'data' => \yii\helpers\ArrayHelper::map(\backend\modules\customers\models\Customers::find()->all(), 'id', 'name'),
                'language' => 'de',
                'options' => [
                    'placeholder' => 'Select a customers.',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label("اسم العميل");
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?=
            $form->field($model, 'judiciary_actions_id')->widget(kartik\select2\Select2::class, [
                'data' => \yii\helpers\ArrayHelper::map(backend\modules\judiciaryActions\models\JudiciaryActions::find()->all(), 'id', 'name'),
                'language' => 'de',
                'options' => [
                    'placeholder' => 'Select a judiciary action.',
                    'multiple' => true
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-lg-6">
            <?=
            $form->field($model, 'year')->widget(kartik\select2\Select2::class, [
                'data' => \yii\helpers\ArrayHelper::map(backend\modules\judiciary\models\Judiciary::find()->all(), 'year', 'year'),
                'language' => 'de',
                'options' => [
                    'placeholder' => 'Select a judiciary year.',
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
            $form->field($model, 'created_by')->widget(kartik\select2\Select2::class, [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username'),
                'language' => 'de',
                'options' => [
                    'placeholder' => 'Select a judiciary action.',

                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-lg-6">
            <?=
            $form->field($model, 'court_name')->widget(kartik\select2\Select2::class, [
                'data' => \yii\helpers\ArrayHelper::map(\backend\modules\court\models\Court::find()->all(), 'id', 'name'),
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
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?=
            $form->field($model, 'form_action_date')->widget(kartik\date\DatePicker::class, ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]])->label(Yii::t('app', 'من تاريخ الحركه'));
            ?>

        </div>
        <div class="col-lg-6">
            <?=
            $form->field($model, 'to_action_date')->widget(kartik\date\DatePicker::class, ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]])->label(Yii::t('app', 'الى تاريخ الحركه'));
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?=
            $form->field($model, 'from_create_at')->widget(kartik\date\DatePicker::class, ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]])->label(Yii::t('app', 'من تاريخ '));
            ?>

        </div>
        <div class="col-lg-6">
            <?=
            $form->field($model, 'to_create_at')->widget(kartik\date\DatePicker::class, ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]])->label(Yii::t('app', 'الى تاريخ '));
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?=
            $form->field($model, 'lawyer_name')->widget(kartik\select2\Select2::class, [
                'data' => \yii\helpers\ArrayHelper::map(\backend\modules\lawyers\models\Lawyers::find()->all(), 'id', 'name'),
                'language' => 'de',
                'options' => [
                    'placeholder' => 'Select a judiciary action.',

                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'contract_id')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'number_row')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6">
            <?=
            $form->field($model, 'contract_not_in_status')->dropDownList(['active' => 'active', 'finished' => 'finished']);
            ?>
        </div>
    </div>
    <div>
        <div class="form-group">
            <?= yii\helpers\Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php yii\widgets\ActiveForm::end() ?>
</div>