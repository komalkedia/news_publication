<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['confirmauth','id'=>base64_encode($user->id),'key'=>$user->auth_key]); 
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Follow the link below to verify email:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
