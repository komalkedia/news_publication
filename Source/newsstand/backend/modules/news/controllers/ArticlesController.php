<?php

namespace backend\modules\news\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\modules\news\models\Articles;
use backend\modules\news\models\ArticleSearch;
use common\newslibrary\NewsController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/**
 * ArticlesController implements the CRUD actions for Articles model.
 */
class ArticlesController extends NewsController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
			'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','create','view','delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, ['is_deleted'=>0, 'useremail'=>Yii::$app->user->identity->username]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
     * Creates a new Articles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Articles();

        if ($model->load(Yii::$app->request->post())) {
			
			//Upload image file
			if(!empty($_FILES['Articles']['name']['imageFile'])) {				
				$model->imageFile = UploadedFile::getInstance($model, 'imageFile');				
				$uploadpath= '/assets/uploads/';
				$file=$model->imageFile;
				$filebasename=str_replace(' ', '_',$file->baseName);
				$filename=$uploadpath.$filebasename.time().'.'.$file->extension;
				$file->saveAs(Yii::getAlias('@webroot').$filename);
				$model->imageurl = Yii::getAlias('@web') .$filename;
				$model->imageFile ='';
			}
			//current date and time
			$model->createdat=Yii::$app->basicutil->getCurrentDT();
			//login user email
			$model->useremail=Yii::$app->user->identity->username;
			if($model->save())
				return $this->redirect(['view', 'id' => $model->id]);
        }
		return $this->render('create', [
			'model' => $model,
		]);
    }


    /**
     * Deletes an existing Articles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model=$this->findModel($id);
		$model->is_deleted=1;
		$model->save();
        return $this->redirect(['index']);
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
