<?php 
	use yii\helpers\Html;
	use yii\web\View;
	
?>
<div style="display:none" class="ld" id="loader_div">
			<div class="loading_image">
				<div class="valid"><?= Html::img('@web/images/loader.gif', ['alt' => 'loading...']) ?></div>
			</div>
</div>
