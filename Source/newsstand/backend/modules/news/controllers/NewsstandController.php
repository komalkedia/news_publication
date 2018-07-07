<?php

namespace backend\modules\news\controllers;

use Yii;
use backend\modules\news\models\Articles;
use backend\modules\news\models\ArticleSearch;
use common\newslibrary\NewsController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\feed\FeedDriver;
use mPDF;

/**
 * ArticlesController implements the CRUD actions for Articles model.
 */
class NewsstandController extends NewsController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Articles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $articles = Articles::find()->active()->orderBy('id DESC')->limit(10)->all();

        return $this->render('index', [
            'articles' => $articles
        ]);
    }

    /**
     * Displays a single Articles model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
	
    /**
     * Export to pdf
     * @param integer $id
     * @return mixed
     */
    public function actionExport($id)
    {
		$mpdf=new mPDF();
		$model=$this->findModel($id);
        $mpdf->WriteHTML($this->renderPartial('view', [
            'model' => $model,
        ]));
        $mpdf->Output(substr($model->title,0, 10).'.pdf', 'D');
        exit;
    }

	//Generate Rss feed
	public function actionRss(){

		$feed=Yii::$app->feed->writer();
		
		$feed->setTitle('News Publishing');
		$feed->setLink(Yii::$app->urlManager->createAbsoluteUrl(''));
		$feed->setFeedLink(Yii::$app->urlManager->createAbsoluteUrl('news/newsstand/rss'), 'rss');
		$feed->setDescription(Yii::t('app','Recent headlines'));
		$feed->setGenerator(Yii::$app->urlManager->createAbsoluteUrl('news/newsstand/rss'));
		$feed->setDateModified(time());
		/**
		* Add one or more entries. Note that entries must
		* be manually added once created.
		*/
		$articles = Articles::find()->active()->orderBy('id DESC')->limit(10)->all();
		foreach($articles as $article){
				$entry = $feed->createEntry();
				$entry->setTitle($article->title);
				$entry->setLink(Yii::$app->urlManager->createAbsoluteUrl('/newsstand/view',['id'=>$article->id]));
				$entry->setDateCreated(intval($article->createdat));
				$entry->setDescription(
				   $article->description
				);
				/* $entry->setEnclosure(
					[
					 'uri'=>Yii::$app->urlManager->createAbsoluteUrl($article->imageurl),
					 'type'=>'image/jpeg',
					 'length'=>@filesize(Yii::$app->urlManager->createAbsoluteUrl($article->imageurl))
					 ]
				); */
				$feed->addEntry($entry);
		}
		/**
		* Render the resulting feed to Atom 1.0 and assign to $out.
		* You can substitute "atom" with "rss" to generate an RSS 2.0 feed.
		*/
		$out = $feed->export('rss');
		header('Content-type: text/xml');
		echo $out;
		die();
	}
	
    /**
     * Finds the Articles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Articles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Articles::find()->where(['id'=>$id])->active()->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
