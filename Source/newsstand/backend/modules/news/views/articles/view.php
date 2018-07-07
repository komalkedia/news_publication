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

    <p>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
            'title',
            [
				'attribute'=>'imageurl',
				'format'=>'raw',
				'value'=>'<a href="'.$model->imageurl.'" target="_blank">'.Html::img($model->imageurl, ['width'=>'80px', 'height'=>'80px']).'</a>'
			],
            'description:ntext',
            'createdat',
            'useremail:email',
        ],
    ]) ?>

</div>
