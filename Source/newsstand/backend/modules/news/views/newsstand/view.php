<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\news\models\Articles */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-view">

    <h1><?= Html::encode($this->title) ?></h1>
	<div class="text-muted">
		<a href="<?php echo Yii::$app->request->baseurl;?>/news/newsstand/export?id=<?php echo $model->id;?>" class="btn btn-primary pull-right">Export to PDF <i class="fa fa-file-pdf-o"></i> </a>
		<span class="pull-left"><strong><?php echo date("F jS, Y H:i:s",strtotime($model->createdat)); ?></strong></span>
	<div class="clearfix"></div>
	</div>

	<?php echo Html::img($model->imageurl, ['class'=>'img-responsive']);?>
	<?php echo $model->description;?>
   

</div>
