<?php

use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
?>
<div class="panel-body">
    <?php
    DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.addrres-item', // required: css class
        'limit' => 100000000000000000, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.addrres-add-item', // css class
        'deleteButton' => '.addrres-remove-item', // css class
        'model' => $modelsAddress[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'address',
        ],
    ]);
    ?>

    <div class="container-items">
        <?php foreach ($modelsAddress as $i => $modelAddress): ?>
            <div class="addrres-item panel panel-default"><!-- widgetBody -->

                <div class="panel-body">
                    <?php
                    // necessary for update action.
                    if (!$modelAddress->isNewRecord) {
                        echo Html::activeHiddenInput($modelAddress, "[{$i}]id");
                    }
                    ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <?= $form->field($modelAddress, "[{$i}]address")->textInput(['maxlength' => true]) ?>

                        </div>
                        <div class="col-sm-5">
                            <?= $form->field($modelAddress, "[{$i}]address_type")->dropDownList([1 => 'عنوان العمل', 2 => 'عنوان السكن']) ?>

                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="addrres-remove-item btn btn-danger btn-xs" style="margin-top: 30px;">
                                <i class="glyphicon glyphicon-minus"></i>
                            </button>
                        </div>
                    </div><!-- .row -->
                </div>
            </div>
        <?php endforeach; ?>

    </div>
    <div class="pull-right">
        <button type="button" class="addrres-add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>

    </div>
    <?php DynamicFormWidget::end(); ?>
</div>