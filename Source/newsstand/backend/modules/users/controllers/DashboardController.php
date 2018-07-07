<?php
namespace backend\modules\users\controllers;


use Yii;
use yii\web\Response;
use yii\filters\AccessControl;
use common\newslibrary\NewsController;
use common\models\LoginForm;
use common\models\SignupForm;
use common\models\User;
use common\models\PasswordResetRequestForm;
use common\models\ResetPasswordForm;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class DashboardController extends NewsController
{
	public $defaultAction = 'login';
	
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
                        'actions' => ['login', 'error','request-password-reset','reset-password', 'signup', 'confirmauth'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'change-password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

	
	///Signup User and send confirmation link in e-mail id
	public function actionSignup()
    {
		if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
				$email = \Yii::$app->mailer->compose(['html' => 'confirmation-html', 'text' => 'confirmation-text'], ['user' => $user])
				->setTo($user->username)
				->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name])
				->setSubject('Signup Confirmation')
				->send();
				if($email){
				Yii::$app->getSession()->setFlash('success','Confirmation link has been sent to your email!');
				}
				else{
				Yii::$app->getSession()->setFlash('error',"Confirmation email failed and was not sent. Please contact admin!");
				}				
				return $this->goHome();
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
	
	////verify confirmation link sent on email
	public function actionConfirmauth($id, $key)
	{
		$idDecoded=base64_decode(urldecode($id));
		$user = User::find()->where([
				'id'=>$idDecoded,
				'auth_key'=>$key,
				])->one();
		if(!empty($user)){
			$user->status=10;
			$user->save();
			Yii::$app->getSession()->setFlash('success','Congratulations!!! Your account has been activated.');
			
			if (Yii::$app->getUser()->login($user)) {
                return  $this->redirect(['change-password', 'id'=>$id]);
            }
		}
		else{
			Yii::$app->getSession()->setFlash('error','Failed to activate. Please contact support.');
		}
		return $this->goHome();
	}
	
	////change password - after account activation page
    public function actionChangePassword($id)
    {
		if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
		$idDecoded=base64_decode(urldecode($id));
        $model = $this->findModel($idDecoded);//User::find()->where(['id'=>$idDecoded])->one();
		if ( !$model || \Yii::$app->user->id!=$idDecoded)
		{
			throw new NotFoundHttpException('User not found.');
		}
		if($model->load(Yii::$app->request->post())){
			
			$resetPasswordToken= $model->generatePasswordResetToken();				 
			$model->password_reset_token = $resetPasswordToken;
			$model->setAttribute("password_reset_token",$resetPasswordToken); 

			$generated_pwd = $_POST['User']['password'];
			$password= $model->setPassword($generated_pwd);
			$model->password=$password;
			$model->repeat_password=$password;
            if ($model->save()) {
				\Yii::$app->getSession()->setFlash('success', "Your password has been changed successfully!");
				return $this->redirect(['/']);
            }	
		}
		return $this->render('change-password', ['model'=>$model]);
    }
	
	//Login user after activated
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

	//logout current user session
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
	/*----------------*
	 * PASSWORD RESET *
	 *----------------*/
    /**
     * Sends email that contains link for password reset action.
     *
     * @return string|\yii\web\Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) 
        {
            if ($model->sendEmail()) 
            {
                Yii::$app->session->setFlash('success', 
                    'Check your email for further instructions.');
                return $this->goHome();
            } 
            else 
            {
                Yii::$app->session->setFlash('error', 
                    'Sorry, we are unable to reset password for email provided.');
            }
        }
        return $this->render('requestPasswordResetToken', [
			'model' => $model,
		]);
    }
    /**
     * Resets password.
     *
     * @param  string $token Password reset token.
     * @return string|\yii\web\Response
     *
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try 
        {
            $model = new ResetPasswordForm($token);
        } 
        catch (InvalidParamException $e) 
        {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->load(Yii::$app->request->post()) 
            && $model->validate() && $model->resetPassword()) 
        {
            Yii::$app->session->setFlash('success', 'New password was saved.');
            return $this->goHome();
        }
        else
        {
            return $this->render('resetPassword', [
                'model' => $model,
            ]);
        }       
    }    

	
	/**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
	protected function findModel($id)
    {
        if (($model = User::find()->where(['id'=>$id, 'status'=>10])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The ID does not exist.');
        }
    }
}
