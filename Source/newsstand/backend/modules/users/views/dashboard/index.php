<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dashboard';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-index">
<?php echo yii\base\View::render('@common/views/elements/_flash.php') ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<i class="fa fa-users"></i> Customers', ['list'], ['class' => 'btn btn-success']) ?>
   
        <?= Html::a('<i class="fa fa-database"></i> Database Backups', 'user-list-backup', ['class' => 'btn btn-success']) ?>
    
        <?php //echo Html::a('<i class="fa fa-download"></i> Admin Backup', ['settings/backup'], ['class' => 'btn btn-success','data-confirm' => Yii::t('yii', 'It will start downloading backup file. Are you sure?')]) ?>
    </p>

   

</div>
