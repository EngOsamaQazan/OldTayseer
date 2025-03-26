<?php

use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;

use borales\extensions\phoneInput\PhoneInput;
?>

<div class="panel-body">
    <?php
    DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper2', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items2', // required: css class selector
        'widgetItem' => '.phone-numbers-item', // required: css class
        'limit' => 100000000000000000000, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.phone-numbers-add-item', // css class
        'deleteButton' => '.phone-numbers-remove-item', // css class
        'model' => $modelsPhoneNumbers[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'address',
        ],
    ]);
    ?>

    <div class="container-items2">
        <?php foreach ($modelsPhoneNumbers as $i => $modelPhoneNumbers): ?>
            <div class="phone-numbers-item panel panel-default"><!-- widgetBody -->

                <div class="panel-body">
                    <?php
                    // necessary for update action.
                    if (!$modelPhoneNumbers->isNewRecord) {
                        echo Html::activeHiddenInput($modelPhoneNumbers, "[{$i}]id");
                    }
                    ?>
                    <div class="row">
                        <div class="col-sm-3" style="width: 17%;">
                            <label>ارقام المعرفين</label>
                            <br>
                            <?= $form->field($modelPhoneNumbers, "[{$i}]phone_number")->widget(PhoneInput::className(), [
                                'jsOptions' => [
                                    'preferredCountries' => ['jo'],
                                ]


                            ])->label(false); ?>

                        </div>
                        <div class="col-sm-3">
                            <?= $form->field($modelPhoneNumbers, "[{$i}]owner_name")->textInput(['maxlength' => true]) ?>

                        </div>
                        <div class="col-sm-3">
                            <?= $form->field($modelPhoneNumbers, "[{$i}]fb_account")->textInput(['maxlength' => true]) ?>

                        </div>
                        <div class="col-sm-2">
                            <?=
                            $form->field($modelPhoneNumbers, "[{$i}]phone_number_owner")->dropDownList(yii\helpers\ArrayHelper::map(\backend\modules\cousins\models\Cousins::find()->all(),'id','name'));
                            ?>

                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="phone-numbers-remove-item btn btn-danger btn-xs" style="margin-top: 30px;">
                                <i class="glyphicon glyphicon-minus"></i>
                            </button>
                        </div>
                    </div><!-- .row -->
                </div>
            </div>
        <?php endforeach; ?>

    </div>
    <div class="pull-right">
        <button type="button" class="phone-numbers-add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>

    </div>
    <?php DynamicFormWidget::end(); ?>
</div>