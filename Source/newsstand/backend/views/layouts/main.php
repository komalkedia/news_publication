<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
$userid='';
if(!Yii::$app->user->isGuest)
	$userid=Yii::$app->user->id;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>
<body>
    <?php $this->beginBody() ?>
	<?php echo \Yii::$app->view->renderFile('@common/views/elements/_loader_generate.php'); ?>

    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'News Publishing',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [];
            if (Yii::$app->user->isGuest) {
				$menuItems[] =['label' => 'Signup', 'url' => ['/signup']];
                $menuItems[] = ['label' => 'Login', 'url' => ['/login']];
            } else {

				$menuItems[] =['label' => 'My Articles', 'url' => ['/news/articles/']];
				$menuItems[] =['label' => 'Change Password', 'url' => ['/change-password', 'id'=>base64_encode($userid)]];
                $menuItems[] = [
                    'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/users/dashboard/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; News Publishing <?= date('Y') ?></p>
        <p class="pull-right"><a href="<?php echo Yii::$app->request->baseurl; ?>/news/newsstand/rss" class="btn btn-warning" target="_blank"><i class="fa fa-rss"></i> RSS</a></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
