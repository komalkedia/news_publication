<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>
<?php echo yii\base\View::render('@common/views/elements/_flash.php') ?>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'password',['inputOptions'=>['class'=>'form-control dummyPassword']])->passwordInput() ?>
				<input type="hidden" name="LoginForm[password]" id="actualPassword" value="" />
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <div class="form-group">
                    <?= Html::Button('Login', ['class' => 'btn btn-primary login-button', 'name' => 'login-button']) ?>
					<div style="color:#999;margin:1em 0">
						<?= Yii::t('app', 'If you forgot your password you can') ?>
						<?= Html::a(Yii::t('app', 'reset it'), ['request-password-reset']) ?>.
					</div>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
	$baseurl=Yii::$app->request->baseUrl;
	$host=Yii::$app->request->hostinfo;
	$this->registerJs("jQuery('.login-button').click(function(e){
			e.preventDefault();
			loginform = jQuery(this).closest('form');
			dPass=jQuery('.dummyPassword').val();
			jQuery('#actualPassword').val(dPass);
			loginform.find('input').attr('readonly',true);
			jQuery('.dummyPassword').attr('disabled',true);
			loginform.submit();
			//jQuery('.dummyPassword').attr('disabled',false);
			//loginform.find('input').attr('readonly',false);
	});", $this::POS_END, 'check-customerid');?>
