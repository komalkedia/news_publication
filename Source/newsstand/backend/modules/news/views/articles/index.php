<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\news\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Articles', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
			'class' => 'yii\grid\SerialColumn'],
           // 'id',
            'title',
			[
				'attribute'=>'imageurl',
				'format'=>'raw',
				'filter'=>false,
				'value'=>function($model)
						{
							return '<a href="'.$model->imageurl.'" target="_blank">'.Html::img($model->imageurl, ['width'=>'80px', 'height'=>'80px']).'</a>';
						}
			],
			[
				'attribute'=>'description',
				'value'=>function($model)
						{
							return substr($model->description,0, 100). '....';
						}
			],
            //'description:ntext',
			[
				'attribute'=>'createdat',
				'filter'=>false,
			],
            [
				'class' => 'yii\grid\ActionColumn',
				'template'=>'{view}{delete}'
			],
        ],
    ]); ?>
</div>
