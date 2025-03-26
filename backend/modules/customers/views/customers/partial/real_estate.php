<?php

use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
?>
<div class="panel-body">
    <?php
    DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper122', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items111', // required: css class selector
        'widgetItem' => '.real_estate-item', // required: css class
        'limit' => 100000000000000000, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.real-estate-add-item', // css class
        'deleteButton' => '.real-estate-remove-item', // css class
        'model' => $modelRealEstate[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'property_type',
            'property_number',
        ],
    ]);
    ?>

    <div class="container-items111">
        <?php foreach ($modelRealEstate as $i => $modelRealEstate): ?>
            <div class="real_estate-item panel panel-default"><!-- widgetBody -->

                <div class="panel-body">
                    <?php
                    // necessary for update action.
                    if (!$modelRealEstate->isNewRecord) {
                        echo Html::activeHiddenInput($modelRealEstate, "[{$i}]id");
                    }
                    ?>
                    <div class="row">

                            <div class="col-sm-4">
                                <?= $form->field($modelRealEstate, "[{$i}]property_type")->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($modelRealEstate, "[{$i}]property_number")->textInput(['maxlength' => true]) ?>  </div>

                        <div class="col-sm-4">
                            <button type="button" class="real-estate-remove-item btn btn-danger btn-xs" style="margin-top: 30px;">
                                <i class="glyphicon glyphicon-minus"></i>
                            </button>
                        </div>
                    </div><!-- .row -->
                </div>
            </div>
        <?php endforeach; ?>

    </div>
    <div class="pull-right">
        <button type="button" class="real-estate-add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>

    </div>
    <?php DynamicFormWidget::end(); ?>
</div>