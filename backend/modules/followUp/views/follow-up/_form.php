<?php


use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use backend\modules\contractInstallment\models\ContractInstallment;
use backend\modules\contracts\models\Contracts;
use kartik\date\DatePicker;
use yii\widgets\Pjax;
use common\helper\LoanContract;
use yii\helpers\ArrayHelper;
use backend\modules\followUp\helper\ContractCalculations;
use yii\base\View;

/* @var $this yii\web\View */
/* @var $model common\models\FollowUp */
/* @var $form yii\widgets\ActiveForm */

$contractCalculations = new ContractCalculations($contract_id);
CrudAsset::register($this);
$date1 = new DateTime($model->date_time);
$date2 = new DateTime(date('Y-m-d h:m:s'));

$diff = $date2->diff($date1);

$hours = $diff->h;
$hours = $hours + ($diff->days * 24);

?>
<div class="contracts-form">
    <?php


    echo $this->render('partial/tabs.php', ['model' => $model, 'contract_id' => $contract_id, 'contractCalculations' => $contractCalculations, 'modelsPhoneNumbersFollwUps' => $modelsPhoneNumbersFollwUps]);

    ?>
    <div style="text-align: center;color:brown">
        <h2>
            <?= $contractCalculations->contract_model->status ?>: حالة العقد
        </h2>
        <?php if ($contractCalculations->contract_model->is_can_not_contact == 1) { ?>
            <p><?= Yii::t('app', 'تم الابلاغ انه لا يوجد ارقام تواصل') ?></p>
        <?php } ?>

    </div>
    <div class="contact-installment-form">
        <div class="row">
            <div class="col-sm-12 text-center follow-up-info-box">
                <h5>
                    <legend>
                        <h3><?= Yii::t('app', 'Contract Notes') ?></h3>
                    </legend>
                    <?php echo ($contractCalculations->contract_model->notes != "") ? $contractCalculations->contract_model->notes : Yii::t('app', "no notes"); ?>
                </h5>
            </div>
        </div>
        <?php
        $result = Contracts::findOne($contract_id);
        if ($model->isNewRecord) {
            $form = ActiveForm::begin(['action' => Url::to(['/followUp/follow-up/create', 'contract_id' => $contract_id]), 'id' => 'dynamic-form']);
        } else {
            $form = ActiveForm::begin(['action' => Url::to(['/followUp/follow-up/update', 'contract_id' => $contract_id, 'id' => Yii::$app->getRequest()->getQueryParam('id')]), 'id' => 'dynamic-form']);
        }
        ?>
        <?= $form->field($model, 'contract_id')->hiddenInput(['value' => $contract_id])->label(false) ?>
        <?= $form->field($model, 'created_by')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>
        <legend>
            <h3><?= Yii::t('app', 'Follow Up Information') ?></h3>
        </legend>
    </div>
    <div class="row">
        <div class="col-sm-3 col-xs-3">
            <?= $form->field($model, 'connection_goal')->dropDownList([1 => 'تحصيل', 2 => 'مصالحة', 3 => 'انهاء عقد'], ['prompt' => '']) ?>
        </div>
        <div class="col-sm-3 col-xs-3">
            <?= $form->field($model, 'reminder')->widget(DatePicker::class, ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]]);
            ?>
        </div>
        <div class="col-sm-3 col-xs-3">
            <?=
            $form->field($model, 'promise_to_pay_at')->widget(DatePicker::class, [
                'options' => ['placeholder' => Yii::t('app', 'Enter Date of sale ...')],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'multidate' => false
                ]
            ]);
            ?>
        </div>
        <div class="col-sm-3 col-xs-3">
            <?= $form->field($model, 'feeling')->dropDownList(yii\helpers\ArrayHelper::map(\backend\modules\feelings\models\Feelings::find()->all(), 'id', 'name'), ['prompt' => '']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>
        </div>
    </div>
    <legend>
        <h3>متابعة الأرقام</h3>
    </legend>
    <div class="row">
        <?php
        echo $this->render('partial/phone_numbers_follow_up', [
            'form' => $form,
            'model' => $result,
            'modelsPhoneNumbersFollwUps' => $modelsPhoneNumbersFollwUps,
        ]);
        ?>
    </div>
    <?php if (!$model->isNewRecord) {
        if ($hours < 2) {


            ?>
            <div class="row">
                <div class="col-sm-4 col-xs-4">
                    <?php if (!Yii::$app->request->isAjax) { ?>
                        <div class="form-group">
                            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php }
    } if ($model->isNewRecord) {?>
        <div class="row">
            <div class="col-sm-4 col-xs-4">
                <?php if (!Yii::$app->request->isAjax) { ?>
                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>


    <?php
    Modal::begin([
        "id" => "ajaxCrudModal",
        "footer" => "", // always need it for jquery plugin
    ]);
    Modal::end();
    ?>
    <?php ActiveForm::end();
    echo $this->render('modals.php', ['contractCalculations' => $contractCalculations, 'contract_id' => $contract_id,]);
    $this->registerJsVar('is_loan', $contractCalculations->contract_model->is_loan, \yii\web\View::POS_HEAD);
    $this->registerJsVar('change_status_url', Url::to(['/followUp/follow-up/change-status']), \yii\web\View::POS_HEAD);
    $this->registerJsVar('send_sms', yii\helpers\Url::to(["/followUp/follow-up/send-sms"], \yii\web\View::POS_HEAD));
    $this->registerJsVar('customer_info_url', Url::to(['/followUp/follow-up/custamer-info']), \yii\web\View::POS_HEAD);

    $this->registerJsFile(Yii::$app->request->baseUrl . '/js/follow-up.js', ['depends' => [\yii\web\JqueryAsset::class]]); ?>

    <link href="" rel="stylesheet">


</div>