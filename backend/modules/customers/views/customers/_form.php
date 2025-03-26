<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\date\DatePicker;
use backend\widgets\ImageManagerInputWidget;
use borales\extensions\phoneInput\PhoneInput;

/* @var $this yii\web\View */
/* @var $model backend\modlues\customers\models\customers */
/* @var $form yii\widgets\ActiveForm */


$jobs = Yii::$app->cache->getOrSet(Yii::$app->params["key_jobs"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['jobs_query'])->queryAll();
}, Yii::$app->params['time_duration']);

$city = Yii::$app->cache->getOrSet(Yii::$app->params["key_city"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['city_query'])->queryAll();
}, Yii::$app->params['time_duration']);

$citizen = Yii::$app->cache->getOrSet(Yii::$app->params["key_citizen"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['citizen_query'])->queryAll();
}, Yii::$app->params['time_duration']);

$HearAboutUs = Yii::$app->cache->getOrSet(Yii::$app->params["key_hear_about_us"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['hear_about_us_query'])->queryAll();
}, Yii::$app->params['time_duration']);

$banks = Yii::$app->cache->getOrSet(Yii::$app->params["key_banks"], function () {
    return Yii::$app->db->createCommand(Yii::$app->params['banks_query'])->queryAll();
}, Yii::$app->params['time_duration']);

?>

<div class="customers-form">

    <?php
    if (isset($id)) {
        $form = ActiveForm::begin(['action' => Url::to(['update', 'id' => $id]), 'options' => ['enctype' => 'multipart/form-data'], 'id' => 'dynamic-form']);
    } else {
        $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'id' => 'dynamic-form']);
    }
    ?>
    <?= $form->errorSummary($model) ?>
    <fieldset>
        <legend>
            <?= Yii::t('app', 'Basic Information') ?>
        </legend>
        <div class="row">
            <div class="col-sm-4 col-xs-4">

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-4 col-xs-4">

                <?= $form->field($model, 'sex')->dropDownList([0 => 'ذكر', 1 => 'انثى'])->label(Yii::t('app', 'Gender')); ?>
            </div>
            <div class="col-sm-4 col-xs-4">
                <?= $form->field($model, 'city')->dropDownList(yii\helpers\ArrayHelper::map($city, 'id', 'name'))->label(Yii::t('app', 'Birth City')); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 col-xs-4">
                <?=
                    $form->field($model, 'birth_date')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => 'Enter Date of sale ...'],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd',
                            'multidate' => false
                        ]
                    ]);
                ?>

            </div>
            <div class="col-sm-4 col-xs-4">
                <?= $form->field($model, 'citizen')->dropDownList(yii\helpers\ArrayHelper::map($citizen, 'id', 'name')); ?>
            </div>
            <div class="col-sm-4 col-xs-4">
                <?= $form->field($model, 'id_number')->textInput(['maxlength' => true])->label(Yii::t('app', 'National Number')) ?>
            </div>


        </div>
        <div class="row">
            <div class="col-sm-4 col-xs-4">
                <?=
                    $form->field($model, 'job_title')->widget(kartik\select2\Select2::classname(), [
                        'data' => \yii\helpers\ArrayHelper::map($jobs, 'id', 'name'),
                        'language' => 'de',
                        'options' => [
                            'placeholder' => 'Select a Jobs.',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                ?>
            </div>
            <div class="col-sm-4 col-xs-4">
                <?= $form->field($model, 'last_job_query_date')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Enter Last Job Query Date ...'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'multidate' => false
                    ]
                ]); ?>
            </div>
            <div class="col-sm-4 col-xs-4">
                <?= $form->field($model, 'total_salary')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">

            <div class="col-sm-4 col-xs-4">
                <?= $form->field($model, 'job_number')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-4 col-xs-4">
                <?= $form->field($model, 'hear_about_us')->dropDownList(yii\helpers\ArrayHelper::map($HearAboutUs, 'id', 'name')); ?>

            </div>

        </div>
        <div class="row">
            <div class="col-sm-4 col-xs-4">
                <?= $form->field($model, 'email')->textInput(); ?>
            </div>
            <div class="col-sm-4 col-xs-4">
                <?= $form->field($model, 'bank_name')->widget(kartik\select2\Select2::classname(), [
                    'data' => yii\helpers\ArrayHelper::map($banks, 'id', 'name'),
                    'options' => [
                        'placeholder' => 'Select a bank name.',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
            </div>
            <div class="col-sm-4 col-xs-4">
                <?= $form->field($model, 'bank_branch')->textInput(['maxlength' => true]) ?>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-4 col-xs-4">
                <?= $form->field($model, 'account_number')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-sm-4 col-xs-4">
                <label class="control-label"> رقم الهاتف الرئيسي</label>
                <br>
                <?= $form->field($model, 'primary_phone_number')->widget(PhoneInput::className(), [
                    'jsOptions' => [
                        'preferredCountries' => ['jo'],
                    ]
                ])->label(false); ?>
            </div>


            <div class="col-sm-4 col-xs-4">
                <?= $form->field($model, 'facebook_account')->textInput(['maxlength' => true]) ?>
            </div>

        </div>
        <div class="row">

            <div class="col-sm-4 col-xs-4">
                <?= $form->field($model, 'do_have_any_property')->dropDownList([0 => 'لا', 1 => 'نعم'], ['prompt' => '']) ?>
            </div>
            <div class="col-sm-4 col-xs-4">
                <?= $form->field($model, 'is_social_security')->dropDownList([0 => 'لا', 1 => 'نعم'], ['prompt' => '']) ?>
            </div>
            <?php
            if (!($model->isNewRecord)) {
                if ($model->is_social_security == 1) {
                    ?>
                    <div class="col-sm-4 col-xs-4  1_social_security_number" style="display: block">
                        <?= $form->field($model, 'social_security_number')->textInput(['maxlength' => true]) ?>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="col-sm-4 col-xs-4 1_social_security_number" style="display: none">
                        <?= $form->field($model, 'social_security_number')->textInput(['maxlength' => true]) ?>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="col-sm-4 col-xs-4 1_social_security_number" style="display: none">
                    <?= $form->field($model, 'social_security_number')->textInput(['maxlength' => true]) ?>
                </div>
            <?php } ?>
        </div>
        <!-- start -->
        <div class="row">
            <!-- ... [existing fields] -->

            <div class="col-sm-4 col-xs-4">
                <?= $form->field($model, 'has_social_security_salary')->dropDownList(['yes' => 'Yes', 'no' => 'No'], ['prompt' => 'Select...']) ?>
            </div>
            <div class="col-sm-4 col-xs-4">
                <?= $form->field($model, 'social_security_salary_source')->dropDownList(Yii::$app->params['socialSecuritySources'], ['prompt' => 'Select...']) ?>
            </div>
            <div class="col-sm-4 col-xs-4">
                <?= $form->field($model, 'retirement_status')->dropDownList(['effective' => 'Effective', 'stopped' => 'Stopped'], ['prompt' => 'Select...']) ?>
            </div>
        </div>

        <div class="row">
            <!-- ... [existing fields] -->

            <div class="col-sm-4 col-xs-4">
                <?= $form->field($model, 'total_retirement_income')->textInput(['type' => 'number', 'step' => '0.01']) ?>
            </div>
            <div class="col-sm-4 col-xs-4">
                <?= $form->field($model, 'last_income_query_date')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Enter Date ...'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ]
                ]) ?>
            </div>


            

        </div>
        <!-- end -->
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <?= $form->field($model, 'notes')->textarea(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="real-estate" style="display: none">
            <legend>
                <?= Yii::t('app', 'العقارات') ?>
            </legend>
            <div class="row">
                <?=
                    $this->render('partial/real_estate', [
                        'form' => $form,
                        'modelRealEstate' => $modelRealEstate
                    ])
                    ?>
            </div>
        </div>
        <legend>
            <?= Yii::t('app', 'Coustmer Address') ?>
        </legend>
        <div class="row">
            <?=
                $this->render('partial/address', [
                    'form' => $form,
                    'modelsAddress' => $modelsAddress
                ])
                ?>
        </div>

        <legend>
            <?= Yii::t('app', 'Coustmer Phone Numbers') ?>
        </legend>
        <div class="row">
            <?=
                $this->render('partial/phone_numbers', [
                    'form' => $form,
                    'modelsPhoneNumbers' => $modelsPhoneNumbers
                ])
                ?>
        </div>

        <legend>
            <?= Yii::t('app', 'Customre Documents') ?>
        </legend>
        <div class="row">
            <?=
                $this->render('partial/customer_documents', [
                    'form' => $form,
                    'customerDocumentsModel' => $customerDocumentsModel
                ])
                ?>
        </div>


        <div class="row">
            <?php
            $image_manager_random_id = rand(100000000, 1000000000);

            if (empty($model->image_manager_id)) {
                $model->image_manager_id = $image_manager_random_id;
            }
            ?>

            <?= $form->field($model, 'selected_image')->hiddenInput() ?>

            <?php if (!$model->isNewRecord && !empty($model->selected_image)) { ?>
                <div class="image-wrapper">
                    <img id="contracts-contract_images_image" alt="Thumbnail" width="400px"
                        class="img-responsive img-preview" src="<?= $model->selectedImagePath ?>">
                </div>
            <?php } ?>



            <?= $form->field($model, 'image_manager_id')->hiddenInput()->label(false); ?>
            <?php
            echo $form->field($model, 'customer_images')->widget(ImageManagerInputWidget::className(), [
                'aspectRatio' => (16 / 9),
                //set the aspect ratio
                'cropViewMode' => 1,
                //crop mode, option info: https://github.com/fengyuanchen/cropper/#viewmode
                'showPreview' => true,
                //false to hide the preview
                'showDeletePickedImageConfirm' => true,
                //on true show warning before detach image
                'groupName' => 'coustmers',
                'contractId' => $model->isNewRecord ? $image_manager_random_id : $model->id,

            ]);
            ?>


        </div>

    </fieldset>

    <div class="row mt-15">
        <div class="col-sm-6 col-xs-6" style="display: inline">
            <?php if (!Yii::$app->request->isAjax) { ?>
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            <?php } ?>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
    <?php
    /* if (!$model->isNewRecord) {


         $data = new yii\data\ArrayDataProvider([
             'key' => 'id',
             'allModels' => \backend\modules\imagemanager\models\Imagemanager::find()->where(['contractId' => $model->id])->andWhere(['groupName' => 'coustmers'])->all()
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
     */?>
</div>
<?php
$this->registerCss("#customers-primary_phone_number {   width: 219% !important;}");
?>

<?php
$this->registerJs(<<<SCRIPT
$(document).on('change','#customers-is_social_security',function(){
if($('#customers-is_social_security').val() == 1 ){
$('.1_social_security_number').css('display','block');
$('#1_primary_phone_number').css('display','none');
$('#2_primary_phone_number').css('display','block');
}else{
$('.1_social_security_number').css('display','none');
$('#1_primary_phone_number').css('display','block');
$('#2_primary_phone_number').css('display','none');
}
})
$(document).on('change','#customers-do_have_any_property',function(){

if($('#customers-do_have_any_property').val() == 1 ){
$('.real-estate').css('display','block');
}else{
$('.real-estate').css('display','none');
}
})
SCRIPT
)
    ?>