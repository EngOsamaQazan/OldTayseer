<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\money\MaskMoney;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use \backend\modules\customers\models\Customers;
use yii\helpers\Url;
use \backend\widgets\ImageManagerInputWidget;
use backend\modules\companies\models\Companies;
use wbraganca\dynamicform\DynamicFormWidget;
use  \backend\modules\customers\models\ContractsCustomers;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model app\models\contracts */
/* @var $form yii\widgets\ActiveForm */
$customers  =   Yii::$app->cache->getOrSet(Yii::$app->params["key_customers"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['customers_query'])->queryAll();
}, Yii::$app->params['time_duration']);


?>

    <div class="contracts-form">

<?php $form = ActiveForm::begin(['id' => 'dynamic-form2']); ?>

    <legend><?= Yii::t('app', 'Contracts Information') ?></legend>
    <div class="row">
        <div class="col-sm-4 col-xs-4" id="solidarity_contract" style="display: none">
            <?=
            $form->field($model, 'customers_ids')->widget(Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map($customers,'id','name'),
                'language' => 'en',
                'options' => ['placeholder' => Yii::t('app', 'Select Customer'),
                    'multiple' => true
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumSelectionLength' => 2,
                ],
            ])->label(Yii::t('app', 'Customers search'));
            ?>

        </div>
        <div class="col-sm-4 col-xs-4" id="normal_contract">
            <?=
            $form->field($model, 'customer_id')->widget(Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map($customers,'id','name'),
                'language' => 'en',
                'options' => ['placeholder' => Yii::t('app', 'Select Customers'),
                    'multiple' => false
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    // 'maximumSelectionLength' => 1,
                ],
                'pluginEvents' => [
                    "change" => "function() { getCustomerData($('#contracts-customer_id').select2('data')[0].id) }",
                ],
            ])->label(Yii::t('app', 'Customers search'));
            ?>

        </div>
        <div class="col-sm-4 col-xs-4">
            <?php $model->isNewRecord == 1 ? $model->type = 'normal' : $model->type; ?>
            <?= $form->field($model, 'type', ['inputOptions' => ['id' => 'contract_type']])->dropDownList(['normal' => Yii::t('app', 'normal'), 'solidarity' => Yii::t('app', 'solidarity')])->label(Yii::t('app', 'Contract Type')); ?>
        </div>
        <div class="col-sm-2 col-xs-2" id="updateCustomer" style="display: none">
            <button title="add customer" class="btn btn-primary"
                    onclick="updateCustomer($('#contracts-customer_id').select2('data')[0].id)"><?= Yii::t('app', 'Update Customer') ?></button>
        </div>

        <div class="col-sm-2 col-xs-2">
            <button title="add customer" class="btn btn-primary"
                    onclick=" window.open('<?= Yii::$app->urlManager->createUrl('/customers/create') ?>', '_blank');
                            return false;"><?= Yii::t('app', 'Add Customer') ?></button>
        </div>
    </div>

    <div id="customer_data">
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <?php
                $dataGuarantor = ContractsCustomers::find()
                    ->select(['c.name'])
                    ->alias('cc')
                    ->innerJoin('{{%customers}} c', 'c.id=cc.customer_id')
                    ->where(['cc.contract_id' => $model->id])
                    ->andWhere(['cc.customer_type' => 'guarantor'])
                    ->createCommand()->queryAll();

                $model->guarantors_ids = $dataGuarantor;
              
               ?>
       
                <?= $form->field($model, 'guarantors_ids')->widget(Select2::classname(), [
                    'data' => yii\helpers\ArrayHelper::map($customers,'id','name'),
                    'language' => 'en',
                    'value' =>$dataGuarantor,
                    'options' => ['placeholder' => Yii::t('app', 'Select Guarantors'),
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        // 'maximumSelectionLength' => 1,
                    ],
                    'pluginEvents' => [
                        "change" => "function() { getCustomerData($('#contracts-customer_id').select2('data')[0].id) }",
                    ],
                ])->label(Yii::t('app', 'Guarantors Search')); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3 col-xs-3">
                <label for="total_contracts"><?= Yii::t('app', 'Total Contracts') ?></label>
                <?= Html::input('text', 'total_contracts', '', ['class' => 'form-control', 'id' => 'total_contracts', 'readOnly' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <label for="name"><?= Yii::t('app', 'Name') ?></label>
                <?= Html::input('text', 'name', '', ['class' => 'form-control', 'id' => 'name', 'readOnly' => true]) ?>
            </div>
            <div class="col-sm-6 col-xs-6">
                <label for="id id_number"><?= Yii::t('app', 'Id Number') ?></label>
                <?= Html::input('text', 'id_number', '', ['class' => 'form-control', 'id' => 'id_number', 'readOnly' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <label for="birth_date"><?= Yii::t('app', 'Birth Date') ?></label>
                <?= Html::input('text', 'birth_date', '', ['class' => 'form-control', 'id' => 'birth_date', 'readOnly' => true]) ?>
            </div>
            <div class="col-sm-6 col-xs-6">
                <label for="email"><?= Yii::t('app', 'Email') ?></label>
                <?= Html::input('text', 'email', '', ['class' => 'form-control', 'id' => 'email', 'readOnly' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <label for="job_title"><?= Yii::t('app', 'Job Title') ?></label>
                <?= Html::input('text', 'job_title', '', ['class' => 'form-control', 'id' => 'job_title', 'readOnly' => true]) ?>
            </div>
            <div class="col-sm-6 col-xs-6">
                <label for="bank_name"><?= Yii::t('app', 'Bank Name') ?></label>
                <?= Html::input('text', 'bank_name', '', ['class' => 'form-control', 'id' => 'bank_name', 'readOnly' => true]) ?>
            </div>
        </div>
    </div>
    <fieldset>
    <legend><?= Yii::t('app', 'Basic Information') ?></legend>
    <div class="row">

        <div class="col-sm-6 col-xs-6">
            <?= $form->field($model, 'company_id')->widget(Select2::classname(), [
                'data' =>  yii\helpers\ArrayHelper::map(Companies::find()->all(), 'id', 'name'),

                'options' => [
                    'placeholder' => Yii::t('app', 'أختر شركة'),
                    'multiple' => false,
                    'data-model-id' => $model->id,
                    'id' => 'company_id',
                ],

                'pluginEvents' => [
                    "change" => "function() { getCompanyItems() }",
                ],
            ])->label(Yii::t('app', 'أختر شركة'));
            ?>
        </div>
        <div class="col-sm-6 col-xs-6">
            <?php
            if ($model->isNewRecord) {
                $model->Date_of_sale = date('Y-m-d');
            }
            ?>
            <?=
            $form->field($model, 'Date_of_sale')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => Yii::t('app', 'Enter Date of sale ...')],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'multidate' => false
                ]
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xs-6">
            <?=
            $form->field($model, 'first_installment_value')->widget(MaskMoney::classname(), [
                'pluginOptions' => [
                    'prefix' => html_entity_decode('$ '), // the Indian Rupee Symbol
                    'suffix' => '',
                    'affixesStay' => true,
                    'thousands' => ',',
                    'decimal' => '.',
                    'precision' => 0,
                    'allowZero' => false,
                    'allowNegative' => false,
                ], 'pluginEvents' => [
                    "change" => "function() {installment_table()}",
                ],
            ]);
            ?>

        </div>

    </div>
    <div class="row">
        <div class="col-sm-2 col-xs-2">
            <?php
            if ($model->isNewRecord) {
                $model->total_value = backend\modules\contracts\models\Contracts::DEFAUULT_TOTAL_VALUE;
            }
            ?>
            <?=
            $form->field($model, 'total_value')->widget(MaskMoney::classname(), [
                'pluginOptions' => [
                    'prefix' => html_entity_decode('$ '), // the Indian Rupee Symbol
                    'suffix' => '',
                    'affixesStay' => true,
                    'thousands' => '',
                    'decimal' => '.',
                    'precision' => 0,
                    'allowZero' => false,
                    'allowNegative' => false,
                ], 'pluginEvents' => [
                    "change" => "function() {installment_table()}",
                ],
            ]);
            ?>
        </div>
        <div class="col-sm-10 col-xs-10">
            <label for="total_in_words"><?= Yii::t('app', 'Total In Words') ?></label>
            <?= Html::input('text', 'total_in_words', '', ['class' => 'form-control', 'id' => 'total_in_words', 'readOnly' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xs-6">
            <?php
            if ($model->isNewRecord) {
                $model->monthly_installment_value = \backend\modules\contracts\models\Contracts::MONTHLY_INSTALLMENT_VALE;
            }
            ?>
            <?=
            $form->field($model, 'monthly_installment_value')->widget(MaskMoney::classname(), [
                'pluginOptions' => [
                    'prefix' => html_entity_decode('$ '), // the Indian Rupee Symbol
                    'suffix' => '',
                    'affixesStay' => true,
                    'thousands' => ',',
                    'decimal' => '.',
                    'precision' => 0,
                    'allowZero' => false,
                    'allowNegative' => false,
                ], 'pluginEvents' => [
                    "change" => "function() {installment_table()}",
                ],
            ]);
            ?>
        </div>
        <div class="col-sm-6 col-xs-6">
            <label for="installment_count"><?= Yii::t('app', 'Income\'s count') ?></label>
            <?= Html::input('text', 'installment_count', '', ['class' => 'form-control', 'id' => 'installment_count', 'readOnly' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xs-6">
            <?=
            $form->field($model, 'first_installment_date')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => Yii::t('app', 'Enter  Date of first Income sale ...')],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'multidate' => false
                ], 'pluginEvents' => [
                    "change" => "function() {installment_table()}",
                ],
            ]);
            ?>
        </div>
        <div class="col-sm-6 col-xs-6">
            <?=
            $form->field($model, 'commitment_discount')->widget(MaskMoney::classname(), [
                'pluginOptions' => [
                    'prefix' => html_entity_decode('$ '), // the Indian Rupee Symbol
                    'suffix' => '',
                    'affixesStay' => true,
                    'thousands' => ',',
                    'decimal' => '.',
                    'precision' => 0,
                    'allowZero' => false,
                    'allowNegative' => false,
                ], 'pluginEvents' => [
                    "change" => "function() {installment_table()}",
                ],
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <?= $form->field($model, 'loss_commitment')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>
        </div>
    </div>
    <?php
    $image_manager_random_id = rand(100000000, 1000000000);
    $model->image_manager_id = $image_manager_random_id;
    ?>

    <div class='row'>
        <div class="panel panel-default">
            <div class="panel-heading"><h4><i
                            class="glyphicon glyphicon-envelope"></i><?= Yii::t('app', 'Contract Inventory Item') ?>
                </h4>
            </div>
            <div class="panel-body">
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items', // required: css class selector
                    'widgetItem' => '.item', // required: css class
                    'limit' => 10000000000000000000000000000,
                    'min' => 1, // 0 or 1 (default 1)
                    'insertButton' => '.add-item', // css class
                    'deleteButton' => '.remove-item', // css class
                    'model' => $modelContractInventoryItem[0],
                    'formId' => 'dynamic-form2',
                    'formFields' => [
                        'id',
                        'item_id'
                    ],
                ]); ?>

                <div class="container-items"><!-- widgetContainer -->
                    <?php foreach ($modelContractInventoryItem

                                   as $i => $modelContractInventoryItem): ?>
                    <div class="item panel panel-default"><!-- widgetBody -->
                        <div class="panel-heading">
                            <h3 class="panel-title pull-left"></h3>
                            <div class="pull-right">
                                <button type="button" class="add-item btn btn-success btn-xs"><i
                                            class="glyphicon glyphicon-plus"></i></button>
                                <button type="button" class="remove-item btn btn-danger btn-xs"><i
                                            class="glyphicon glyphicon-minus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?php
                            if (!$modelContractInventoryItem->isNewRecord) {
                                echo Html::activeHiddenInput($modelContractInventoryItem, "[{$i}]id");
                            }
                            ?>

                            <div class="row">
                                <div class="col-sm-6">
                                    <?= $form->field($modelContractInventoryItem, "[{$i}]item_id")->dropDownList(yii\helpers\ArrayHelper::map(\backend\modules\inventoryItems\models\InventoryItems::find()->all(), 'id', 'item_name'))->label(Yii::t('app', 'Item ID')) ?>
                                </div>

                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php DynamicFormWidget::end(); ?>
                </div>
            </div>
        </div>
        <?= $form->field($model, 'selected_image')->hiddenInput()->label(Yii::t('app', 'Selected Image')) ?>

        <?php if (!$model->isNewRecord && !empty($model->selected_image)) { ?>
            <div class="image-wrapper">
                <img id="contracts-contract_images_image" alt="Thumbnail"
                     width="400px"
                     class="img-responsive img-preview"
                     src="<?= $model->selectedImagePath ?>">
            </div>
        <?php } ?>


        <?= $form->field($model, 'image_manager_id')->hiddenInput()->label(false); ?>

        <div class="row">
            <?php
            echo $form->field($model, 'contract_images')->widget(ImageManagerInputWidget::className(), [
                'aspectRatio' => (16 / 9), //set the aspect ratio
                'cropViewMode' => 1, //crop mode, option info: https://github.com/fengyuanchen/cropper/#viewmode
                'showPreview' => true, //false to hide the preview
                'showDeletePickedImageConfirm' => false, //on true show warning before detach image
                'groupName' => 'contracts',
                'contractId' => $model->isNewRecord ? $image_manager_random_id : $model->id,
            ])->label(Yii::t('app', 'Contract Images'));
            ?>
        </div>


        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create & Print') : Yii::t('app', 'Update & Print'), ['name' => 'print', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?php if (!Yii::$app->request->isAjax) { ?>
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?php } ?>
        </div>

        <?php ActiveForm::end(); ?>
        <div class="row">

            <div class="col-sm-12 col-xs-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"><?= Yii::t('app', 'Amount') ?></th>
                        <th scope="col"><?= Yii::t('app', 'Month') ?></th>
                        <th scope="col"><?= Yii::t('app', 'Year') ?></th>
                    </tr>
                    </thead>
                    <tbody id="installment_table_body">

                    </tbody>
                </table>
            </div>
        </div>

        <script type="text/javascript">
            //the dropdown list id; This doesn't have to be a dropdown it can be any field type.
            function getCustomerData(id) {
                //the dropdown list selected locations id
                //var id = $('#customers_ids').val();
                var url = "<?= Url::to(['/customers/customers/customer-data']); ?>" + "?id=" + id;
                //call the action we created above in the conrller
                $.get(url, function (data) {
                        //get the JSON data from the action
                        //var data = $.parseJSON(data);
                        //check if the system found any data
                        if (data !== null) {
                            $("#total_contracts").val(data.contracts_info.count).blur();
                            $("#name").val(data.model.name).blur();
                            $("#city").val(data.model.city).blur();
                            $("#bank_name").val(data.model.bank_name).blur();
                            $("#job_title").val(data.model.job_title).blur();
                            $("#id_number").val(data.model.id_number).blur();
                            $("#birth_date").val(data.model.birth_date).blur();
                            $("#email").val(data.model.email).blur();
                            $("#contracts_info").val(data.contracts_info.count).blur();
                            $("#user_status").val(data.contracts_info.email).blur();
                            $('#updateCustomer').show();
                        } else {
                            //if data wasn't found the alert.
                            alert('We\'re sorry but we couldn\'t load the the customer data!');
                        }
                    }
                );
            }

            function updateCustomer(id) {
                var url = "<?= Url::to(['/customers/customers/update']); ?>" + "?id=" + id;
                window.open(url, '_blank');
            }

            function installment_table() {
                var total_value = $("#contracts-total_value").val();
                var first_installment_value = $("#contracts-first_installment_value").val();
                var monthly_installment_value = $("#contracts-monthly_installment_value").val();
                if (total_value > 0 && first_installment_value > 0 && monthly_installment_value > 0) {
                    $('#installment_table_body').empty();
                    instalments_count = 0;
                    instalments_count = total_value / monthly_installment_value;
                    var year = new Date($('#contracts-first_installment_date').val()).getFullYear();
                    var d = new Date($('#contracts-first_installment_date').val());
                    var m = d.getMonth();
                    var y = 0;

                    for (i = 0; i < instalments_count; i++) {

                        if (i == parseInt(instalments_count)) {
                            var mounthly_instalment = total_value - (monthly_installment_value * (i));
                        } else {
                            var mounthly_instalment = monthly_installment_value;
                        }
                        if (m == 12) {
                            m = 1
                            y++;
                        } else {
                            m++;
                        }
                        var year_string = year + y;
                        var row = '<tr><th scope="row">' + (i + 1) + '</th><td>' + mounthly_instalment + '</td><td>' + m + '</td><td>' + year_string + '</td></tr>';
                        $('#installment_table_body').append(row);
                    }
                    $('#installment_count').val(i);
                }
            }

            function getCompanyItems(update = 0) {
                var id = $('#company_id').val();
                var model_id = $('#company_id').data('model-id');
                var url = "<?= Url::to(['companies/companies/get-items']); ?>" + "?company_id=" + id + "&model_id=" + model_id;
                // console.log(update);
                $.get(url, function (data) {
                    var selected = Object.keys(data.selected);
                    var items = Object.keys(data.items);

                    $('#inventory_item').empty().trigger("change");
                    $.each(data.items, function (index, value) {
                        if (selected.length > 0) {
                            if (selected.includes(index)) {
                                $('#inventory_item').append("<option selected value=" + index + " > " + value + " </option>");
                            } else {
                                $('#inventory_item').append("<option value=" + index + " > " + value + " </option>");
                            }
                        } else {
                            $('#inventory_item').append("<option value=" + index + " > " + value + " </option>");
                        }

                    });

                });

            }

        </script>

        <?php
        if(!$model->isNewRecord){


            $data = new yii\data\ArrayDataProvider([
                'key' => 'id',
                'allModels' => \backend\modules\imagemanager\models\Imagemanager::find()->where(['contractId'=> $model->id])->andWhere(['groupName'=>'contracts'])->all()
            ]);

            echo kartik\grid\GridView::widget([
                'id' => 'table-crud-datatable',
                'dataProvider' => $data,
                'summary' => '',
                'pjax' => true,
                'columns' => [
                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'attribute'=>'fileName',
                        'label'=>Yii::t('app','fileName'),
                        'value'=>function($model){
                            if(empty($model->fileName)){
                                return \yii\helpers\Html::img(Url::to([Yii::$app->params['companies_logo']]),['style' => "width: 50px;height:50px;", 'alt' => 'User Image','class'=>' img-circle']);
                            }
                            return \yii\helpers\Html::img(Url::to(['/images/'.$model->fileName]),['style' => "width: 50px;height:50px;", 'alt' => 'User Image','class'=>' img-circle']);

                        },
                        'format'=>'html',
                        'width'=>'10%',


                    ],

                ],
                'striped' => false,
                'condensed' => false,
                'responsive' => false,
                'export' => false,
            ]);

        }
        ?>
    </div>
<?php $this->registerJs(<<<SCRIPT
$(document).on('change','#contract_type',function(){

let item = $('#contract_type').val();

  if (item == 'normal') {
                        $('#solidarity_contract').hide();
                        $('#normal_contract').show();
                        $('#customer_data').show();
                        $('#updateCustomer').show();
                    } else {
                        $('#solidarity_contract').show();
                        $('#normal_contract').hide();
                        $('#customer_data').hide();
                        $('#updateCustomer').hide();
                    }
});
SCRIPT
);
?>