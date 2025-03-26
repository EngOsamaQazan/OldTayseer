<?php

use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\followUp\helper\ContractCalculations;
use backend\modules\contractInstallment\models\ContractInstallment;
use common\helper\Permissions;

?>

<ul class="nav nav-tabs">
    <li><a data-toggle="tab" href="#menu1"><?= Yii::t('app', 'ارقام هواتف العملاء والمعرفين') ?></a></li>
    <li><a data-toggle="tab" href="#menu2"><?= Yii::t('app', 'البيانات المالية') ?></a></li>
    <li><a data-toggle="tab" href="#menu3"><?= Yii::t('app', 'الدفعات') ?></a></li>
    <li><a data-toggle="tab" href="#menu4"><?= Yii::t('app', 'التسويات') ?></a></li>
    <li><a data-toggle="tab" href="#menu5"><?= Yii::t('app', 'حركات العملاء القضائية') ?></a></li>


    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?= Yii::t('app', 'إجرائات') ?><span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li>
                <?= Html::a(Yii::t('app', 'صور العملاء'), Url::to(['#']), ['class' => 'btn btn-primary', 'data-toggle' => "modal", 'data-target' => "#exampleModalCenter2"]) ?>
            </li>
            <li>
                <?= Html::a(Yii::t('app', 'تغيير حالة العقد'), Url::to(['#']), ['class' => 'btn btn-primary', 'data-toggle' => "modal", 'data-target' => "#changeStatse"]) ?>
            </li>
            <li>
                <?= Html::a(Yii::t('app', 'للتدقيق'), Url::to(['#']), ['class' => 'btn btn-primary', 'data-toggle' => "modal", 'data-target' => "#exampleModal"]) ?>
            </li>
            <li>
                <?= Html::a(Yii::t('app', 'كشف حساب'), Url::to(['printer', 'contract_id' => $contract_id]), ['class' => 'btn btn-primary', 'target' => '_blank']) ?>
            </li>
            <li>
                <?= Html::a(Yii::t('app', 'برائة الذمة'), Url::to(['clearance', 'contract_id' => $contract_id]), ['class' => 'btn btn-primary', 'target' => '_blank']) ?>
            </li>
            <?php if (Yii::$app->user->can(Permissions::MANAGER)) { ?>
                <?php if ($contractCalculations->contract_model->is_can_not_contact == 1) {
                ?>
                    <li>
                        <?= Html::a(Yii::t('app', 'يوجد ارقام هواتف'), Url::to(['/contracts/contracts/is-connect', 'contract_id' => $contract_id]), ['class' => 'btn btn-primary']); ?>
                    </li>
                <?php
                } else {
                ?>
                    <li>
                        <?= Html::a(Yii::t('app', 'لا يوجد ارقام هواتف'), Url::to(['/contracts/contracts/is-not-connect', 'contract_id' => $contract_id]), ['class' => 'btn btn-primary']); ?>
                    </li>
                <?php
                }
                ?>
            <?php } ?>

        </ul>
    </li>
</ul>

<div class="tab-content">
    <div id="menu1" class="tab-pane fade">
        <?= $this->render('tabs/phone_numbers.php', ['contractCalculations' => $contractCalculations, 'contract_id' => $contract_id, 'model' => $model]) ?>
    </div>
    <div id="menu2" class="tab-pane fade">
        <?= $this->render('tabs/financial.php', ['modelsPhoneNumbersFollwUps' => $modelsPhoneNumbersFollwUps, 'contractCalculations' => $contractCalculations, 'contract_id' => $contract_id, 'model' => $model]) ?>
    </div>
    <div id="menu3" class="tab-pane fade">
        <?= $this->render('tabs/payments.php', ['contract_id' => $contract_id, 'model' => $model]) ?>
    </div>
    <div id="menu4" class="tab-pane fade">
        <?= $this->render('tabs/loan_scheduling.php', ['contract_id' => $contract_id, 'model' => $model, 'contractCalculations' => $contractCalculations]) ?>
    </div>
    <div id="menu5" class="tab-pane fade">
        <?= $this->render('tabs/judiciary_customers_actions.php', ['contract_id' => $contract_id, 'model' => $model]) ?>
    </div>
</div>


