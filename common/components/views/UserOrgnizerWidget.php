<?php
use kartik\select2\Select2;
use yii\web\JsExpression;
use common\components\GeneralHelpers;
use yii\helpers\Url;
use common\models\User;
?>
<?php
            $usersName = !($model->isNewRecord) ? User::GetUserByType() : [];
             echo $form->field($model, "representitve")->widget(Select2::classname(), [
                    'data' => $usersName,
                    'maintainOrder' => true,
                    'options' => ['placeholder' => Yii::t('app',"Select $type"),'multiple' => true],
                        'toggleAllSettings' => [
                            'selectLabel' => '',
                            'unselectLabel' => '',
                            'selectOptions' => ['class' => 'text-success'],
                        ],
                    'pluginOptions' => [
                        //'allowClear' => true,
                        'minimumInputLength' => 3,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                        ],
                        'ajax' => [
                            'url' => Url::to(['/dropdown/available-user']),
                            'dataType' => 'json',
                    //        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                        /*'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(city) { return city.text; }'),
                        'templateSelection' => new JsExpression('function (city) { return city.text; }'),*/
                    ],
                ])->label(false);?>
                <p class="notic"><?=yii::t('app','You Can Search by Full-Name, User-Name, Mobile Or Email')?></p>