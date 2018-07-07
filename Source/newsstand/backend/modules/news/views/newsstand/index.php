<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-index">

    <h1><?= Html::encode($this->title) ?></h1>
	<?php echo yii\base\View::render('@common/views/elements/_flash.php') ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?php
	if(count($articles)>0){
	foreach($articles as $article)
	{
?>
	<a href="<?php echo Yii::$app->request->baseurl;?>/newsstand/view?id=<?php echo $article->id;?>" class="hoverDiv">
		<div class="row">
			<div class="col-xs-8 col-sm-9 col-md-10">
				<div class="text-right text-muted"><strong><?php echo date("F jS, Y H:i:s",strtotime($article->createdat)); ?></strong></div>
				<div class="text-justify text-primary"><h4><?php echo $article->title; ?></h4></div>
			</div>
			<div class="col-xs-4 col-sm-3 col-md-2">
				<?php echo Html::img($article->imageurl, ['width'=>'80px', 'height'=>'80px'])?>
			</div>
		</div>
		<div class="clearfix"></div>
		<hr>
		</a>
		
<?php
	}
	}
	else echo "No Articles.";
?>
</div>
