<?php
use yii\helpers\Html;
use backend\modules\notifications\models\notifications;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\components\CompanyChecked;
//$notifications = notifications::findAll(['user_id' => Yii::$app->user->id]);
Yii::$app->view->registerJsVar('base_url', Yii::$app->request->hostInfo . Yii::$app->getUrlManager()->getBaseUrl());
$CompanyChecked = new CompanyChecked();
$primary_company = $CompanyChecked->findPrimaryCompany();
if ($primary_company == '') {
    $logo = $logo = Yii::$app->params['companies_logo'];
    $companyName = '';

} else {
    $logo = $primary_company->logo;
    $companyName = $primary_company->name;
}
/* @var $this \yii\web\View */
/* @var $content string */
?>
<?php
$avatar = \backend\modules\employee\models\EmployeeFiles::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['type' => 0])->orderBy(['id' => SORT_DESC])->one();
//$msgUnreads = \common\models\Notification::find()->where(['recipient_id' => Yii::$app->user->id])->orderBy(['id' => SORT_DESC])->all();
?>
<div class="header">
    <header class="main-header">
        <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . $companyName . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>
        <nav class="navbar navbar-static-top" role="navigation">

            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">

                <ul class="nav navbar-nav">

                    <!-- Messages: style can be found in dropdown.less-->
                 <!--  <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?php // Pjax::begin(['id' => 'notification-count-id']); ?>
                            <span class="fa fa-bell-o"></span> <span
                                    class="label label-warning"><?php //echo  \common\models\Notification::find()->where(['recipient_id' => Yii::$app->user->id])->andWhere(['is_unread' => 1])->count();
                                ?></span>
                            <?php //Pjax::end(); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                              inner menu: contains the actual data
                                <ul class="menu">
                                    <?php
                                  /*  foreach ($msgUnreads

                                    as $msgUnread) {
                                  if ($msgUnread->is_unread == 1) {
                                      */  ?>

                                        <li style="background-color:#81b7de ">
                                            <?php
//                                            $avatar = \common\models\EmployeeFiles::find()->where(['user_id' => $msgUnread->sender_id])->andWhere(['type' => 0])->orderBy(['id' => SORT_DESC])->one();
//                                            if (!empty($avatar->path)) {
//                                                echo "<div style='text-align: left'>".date("Y-m-d H:m:s", $msgUnread->created_time)."</div>";
//                                                echo Html::a(Html::img(Url::to([$avatar->path]), ['style' => "max-width: 37px;max-height:37px;margin-top: 2px;border-radius:50%", 'alt' => 'User Image'])
//                                                    . $msgUnread->title_html, Url::to([$msgUnread->href . '&notificationID=' . $msgUnread->id]));
//                                            } else {
//                                                echo Html::a(Html::img($directoryAsset . "/img/user2-160x160.jpg", ['style' => "max-width: 37px;max-height:37px;margin-top: 2px;border-radius:50%", 'alt' => 'User Image'])
//                                                    . $msgUnread->title_html, Url::to([$msgUnread->href . '&notificationID=' . $msgUnread->id]));
//                                            } 
                                            ?>
                                        </li>
                                    <?php 
                                    
//                                    } else {
                                    ?>
                                    <li>
                                        <?php
//                                        $avatar = \common\models\EmployeeFiles::find()->where(['user_id' => $msgUnread->sender_id])->andWhere(['type' => 0])->orderBy(['id' => SORT_DESC])->one();
//                                        if (!empty($avatar->path)) {
//                                            echo Html::a(Html::img(Url::to([$avatar->path]), ['style' => "max-width: 37px;max-height:37px;margin-top: 2px;border-radius:50%", 'alt' => 'User Image'])
//                                                . $msgUnread->title_html, Url::to([$msgUnread->href . '&notificationID=' . $msgUnread->id]));
//                                        } else {
//                                            echo Html::a(Html::img($directoryAsset . "/img/user2-160x160.jpg", ['style' => "max-width: 37px;max-height:37px;margin-top: 2px;border-radius:50%", 'alt' => 'User Image'])
//                                                . $msgUnread->title_html, Url::to([$msgUnread->href . '&notificationID=' . $msgUnread->id]));
//                                        } 
                                        ?>
                                        <?php
                                     //   }
                                    //    }
                                        ?>
                                    <li>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a
                                        href="#"> <?php //echo Html::a('See All ', Url::to(['notification/see-all-msg'])) ?></a>
                            </li>
                        </ul>
                    </li>-->

                    <li class="dropdown tasks-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger">9</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 9 tasks</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <h3>
                                                Design some buttons
                                                <small class="pull-right">20%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%"
                                                     role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <h3>
                                                Create a nice theme
                                                <small class="pull-right">40%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-green" style="width: 40%"
                                                     role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                    <span class="sr-only">40% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <h3>
                                                Some task I need to do
                                                <small class="pull-right">60%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-red" style="width: 60%"
                                                     role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                    <span class="sr-only">60% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <h3>
                                                Make beautiful transitions
                                                <small class="pull-right">80%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-yellow" style="width: 80%"
                                                     role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                    <span class="sr-only">80% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">View all tasks</a>
                            </li>
                        </ul>
                    </li>
                    <!-- User Account: style can be found in dropdown.less -->

                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <?php
                         if (!empty($avatar->path)) {
                                echo Html::img(Url::to([$avatar->path]), ['style' => "max-width: 37px;max-height:37px;margin-top: 2px;border-radius:50%", 'alt' => 'User Image']) ?>
                            <?php } else {
                                ?>
                                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image"
                                     style="max-width: 37px;max-height:37px;margin-top: 2px ;border-radius: 50% "
                                     alt="User Image"/>
                            <?php } ?>
                            <span class="hidden-xs"><?= Yii::$app->user->identity['username'] ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <?php
                               if (!empty($avatar->path)) {
                                    echo Html::img(Url::to([$avatar->path]), ['style' => "max-width: 37px;max-height:37px;margin-top: 2px;border-radius:50%", 'alt' => 'User Image']) ?>
                                <?php } else {
                                    ?>
                                    <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image"
                                         style="max-width: 37px;max-height:37px;margin-top: 2px ;border-radius: 50% "
                                         alt="User Image"/>
                                <?php } ?>
                                <p>
                                    <span class="hidden-xs"><?= Yii::$app->user->identity['username'] ?></span>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <?= Html::a('Profile', Url::to(['/employee/update', 'id' => Yii::$app->user->id]), ['class' => "btn btn-default btn-flat"]) ?>
                                </div>
                                <div class="pull-right">
                                    <?=
                                    Html::a(
                                        'Sign out', ['/site/logout'], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                    )
                                    ?>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <!-- User Account: style can be found in dropdown.less -->
                    <!-- <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li> -->
                </ul>
            </div>
        </nav>
    </header>
    <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <?php
           if (!empty($avatar->path)) {
                echo Html::img(Url::to([$avatar->path]), ['style' => "max-width: 37px;max-height:37px;margin-top: 2px;border-radius:50%", 'alt' => 'User Image']) ?>
            <?php } else {
                ?>
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image"
                     style="max-width: 37px;max-height:37px;margin-top: 2px ;border-radius: 50% "
                     alt="User Image"/>
            <?php } ?>


            <span class="hidden-xs"><?= Yii::$app->user->identity['username'] ?></span>
        </a>
        <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
                <?php
               if (!empty($avatar->path)) {
                    echo Html::img(Url::to([$avatar->path]), ['style' => "max-width: 37px;max-height:37px;margin-top: 2px;border-radius:50%", 'alt' => 'User Image']) ?>
                <?php } else {
                    ?>
                    <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image"
                         style="max-width: 37px;max-height:37px;margin-top: 2px ;border-radius: 50% "
                         alt="User Image"/>
                <?php } ?>
                <p>
                    <span class="hidden-xs"><?= Yii::$app->user->identity['username'] ?></span>
                </p>
            </li>
            <!-- Menu Body -->
            <li class="user-footer">
                <div class="pull-left">
                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                    <?=
                    Html::a(
                        'Sign out', ['/site/logout'], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                    )
                    ?>
                </div>
            </li>
        </ul>
    </li>
</div>

<?php
/*
$js = <<<SCRIPT
 $(document).ready(function()
    {
   
        setInterval(function()
        {
          $.pjax.reload({container: '#notification-count-id', async: false});
     
        }, 10000); 
    });
    
SCRIPT;
$this->registerJs($js);
*/
?>