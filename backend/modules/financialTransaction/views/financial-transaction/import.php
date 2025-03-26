<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\modules\companies\models\Companies;
use \backend\modules\bancks\models\Bancks;
use \backend\modules\companyBanks\models\CompanyBanks;
/* @var $model \backend\modules\financialTransaction\models\FinancialTransaction */
/* @var $notImportedRecords */

$bank = yii\helpers\ArrayHelper::map(\backend\modules\companyBanks\models\CompanyBanks::find()->all(), 'bank_id', 'bank_id');
$banck_name = yii\helpers\ArrayHelper::map(\backend\modules\bancks\models\Bancks::find()->where(['in', 'id', $bank])->all(),'id','name');

?>

<div class="questions-bank box box-primary">
    <fieldset>
        <legend><?= Yii::t('app', 'Select file to import') ?></legend>
        <div class="row">
            <?php $form = ActiveForm::begin(); ?>
            <div class="col-md-4">
                <?= $form->field($model, 'company_id')->widget(Select2::classname(), [
                    'data' => yii\helpers\ArrayHelper::map(Companies::find()->all(), 'id', 'name'),
                    'language' => 'de',
                    'options' => [
                        'placeholder' => 'Select a company.',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(Yii::t('app', 'Company ID')); ?>
            </div>
            <div class="col-md-4">

                <?= $form->field($model, 'bank_id')->widget(Select2::classname(), [
                    'data' => $banck_name,
                    'language' => 'de',
                    'options' => [
                        'placeholder' => 'Select a company Banck.',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(Yii::t('app', 'Bank ID')); ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'excel_file')->fileInput()->label(Yii::t('app', 'Excel File')); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= Html::submitButton(Yii::t('app', 'Import'), ['class' => 'btn btn-primary btn-md']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>

        <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message): ?>
            <div class="alert alert-<?= $key ?>">
                <?= $message[0] ?>
            </div>
        <?php endforeach; ?>

        <?php if (count($notImportedRecords) > 0): ?>
            <legend><?= Yii::t('app', 'Not imported records') ?></legend>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th><?= Yii::t('app', 'Description') ?></th>
                    <th><?= Yii::t('app', 'Amount') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($notImportedRecords as $key => $record): ?>
                    <tr>
                        <td><?= $record['description'] ?></td>
                        <td><?= $record['amount'] ?></td>

                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </fieldset>
</div>
