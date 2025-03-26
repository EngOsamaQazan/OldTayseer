<?php

use common\components\CompanyChecked;
use yii\helpers\Html;
use yii\helpers\Url;

use backend\modules\notifications\models\notifications;
$CompanyChecked = new CompanyChecked();
$primary_company = $CompanyChecked->findPrimaryCompany();
if ($primary_company == '') {
    $logo = $logo = Yii::$app->params['companies_logo'];
   

} else {
    $logo = $primary_company->logo;
}
?>
<aside class="main-sidebar">
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="row">
                <div class="pull-left image col-lg-4" >
                    <?php
                    if (!empty(Yii::$app->params['logo'])) {
                        echo Html::img('/'.$logo, ['style' => "max-width: 60px;max-height:60px;margin-top: 2px;border-radius:50%",'alt'=>'User Image']) ?>
                    <?php } else {
                        ?>
                        <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image" style="max-width: 37px;max-height:37px;margin-top: 2px ;border-radius: 50% "
                             alt="User Image" />
                    <?php } ?>
                </div>
            </div>
        </div>
<div>
        <?php

        echo dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree',],
                'encodeLabels' => false,
                'items' => require '_menu_items.php'
            ]);

        ?>
</div>

    </section>
</aside>
