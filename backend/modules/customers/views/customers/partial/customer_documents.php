<?php

use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
?>

<div class="panel-body">
    <?php
    DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper3', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items3', // required: css class selector
        'widgetItem' => '.customer-documents-item', // required: css class
        'limit' =>100000, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.customer-documents-add-item', // css class
        'deleteButton' => '.customer-documents-remove-item', // css class
        'model' => $customerDocumentsModel[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'document_number',
            'document_type',
            'images',
        ],
        
    ]);
    ?>

    <div class="container-items3">
        <?php foreach ($customerDocumentsModel as $i => $customerDocumentModel): ?>
            <div class="customer-documents-item panel panel-default"><!-- widgetBody -->

                <div class="panel-body">
                    <?php
                    // necessary for update action.
                    if (!$customerDocumentModel->isNewRecord) {
                        echo Html::activeHiddenInput($customerDocumentModel, "[{$i}]id");
                    }
                    ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <?= $form->field($customerDocumentModel, "[{$i}]document_number")->textInput(['maxlength' => true]) ?>

                        </div>
                        <div class="col-sm-5">
                            <?= $form->field($customerDocumentModel, "[{$i}]document_type")->dropDownList([0 => 'هوية', 1 => 'جواز سفر', 2 => 'رخصة', 3 => 'شهادة ميلاد',4=>' شهادة تعيين']) ?>

                        </div>
                        <div class="col-sm-6">
                            <?= $form->field($customerDocumentModel, "[{$i}]images")->fileInput() ?>

                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="customer-documents-remove-item btn btn-danger btn-xs" style="margin-top: 30px;">
                                <i class="glyphicon glyphicon-minus"></i>
                            </button>
                        </div>
                    </div><!-- .row -->
                </div>
            </div>
<?php endforeach; ?>

    </div>
    <div class="pull-right">
        <button type="button" class="customer-documents-add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>

    </div>
<?php DynamicFormWidget::end(); ?>
</div>