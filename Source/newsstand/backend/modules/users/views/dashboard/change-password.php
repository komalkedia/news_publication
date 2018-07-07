<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$this->title= Yii::t('app','Changing password for user:'). $model->username;
?>
<div class="user-update col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

	<h2 class="lte-hide-title"><?= $this->title ?></h2>	
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="user-form">
			<?php $form = ActiveForm::begin([
					'id'=>'user',
					'layout'=>'horizontal',
				]); ?>

				<?= $form->field($model, 'password')->passwordInput(['maxlength' => 255, 'autocomplete'=>'off','required'=>'required','pattern'=>".{6,}",'required title'=>"6 characters minimum"]) ?>

				<?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 255, 'autocomplete'=>'off','required'=>'required']) ?>
				<?= Html::submitButton(
						'<span class="glyphicon glyphicon-ok"></span> ' . Yii::t('app', 'Save'),
						['class' => 'btn btn-success']
					) ?>
				 <?= Html::a(Yii::t('app', 'Cancel'), ['/user/index'], ['class'=>'btn btn-warning']) ?>

				<?php ActiveForm::end(); ?>			
			</div>
		</div>
    </div>		
</div>