<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Location */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="location-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'active' => 'Active', 'unActive' => 'UnActive', ], ['prompt' => '']) ?>
    
    <?= $form->field($model, 'longitude')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'latitude')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'radius')->textInput(['maxlength' => true]) ?>
    

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
