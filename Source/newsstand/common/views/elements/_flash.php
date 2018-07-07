<?php 
	use yii\helpers\Html;
	use yii\base\view;
	use yii\helpers\Url;
?>
<?php 
$session = Yii::$app->session;
$result = $session->hasFlash('success'); 
	if($result) { 
?>
	
	<div class="col-sm-9 col-md-10 alert-success alert fade in" id="w3-success-0">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<?= Yii::$app->session->getFlash('success'); ?>
	</div>
<?php 
} 
$result = $session->hasFlash('error'); 
	if($result) { 
?>
	
	<div class="col-sm-9 col-md-10 alert-warning alert fade in" id="w3-error-0">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<?= Yii::$app->session->getFlash('error'); ?>
	</div>
<?php } ?>
<div class="clearfix"></div>
<?php
$script = <<< JS
	jQuery('.remove_flash').click(function(e){
		jQuery(this).parent().remove();
		
  });
JS;
$this->registerJs($script);
?>