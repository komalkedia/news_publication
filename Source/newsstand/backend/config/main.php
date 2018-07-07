<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
	'name'=>'News Publishing',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log','gii'],
	'defaultRoute' => 'news/newsstand/index',
    'modules' => [
		    'gii' => [
				'class' => 'yii\gii\Module',
			],
			'users' => [
				'class' => 'backend\modules\users\Users',
			],
			'news' => [
				'class' => 'backend\modules\news\News',
			]
	],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        	'loginUrl' => [ 'users/dashboard/login' ],
            'identityCookie' => [
                'name' => '_backendUser', // unique for backend
            ]
        ],
        'session' => [
            'name' => 'PHPBACKSESSID',
            'savePath' => sys_get_temp_dir(),
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
		'urlManager' => [
            'enablePrettyUrl' => true,
                                                //'urlFormat'=>'path',
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
            		'login'=>'users/dashboard/login',
            		'signup'=>'users/dashboard/signup',
            		'reset-password'=>'users/dashboard/reset-password',
            		'change-password'=>'users/dashboard/change-password',
					'confirmauth'=>'users/dashboard/confirmauth',
					'createnews'=>'news/articles/create',
					'newsstand/view'=>'news/newsstand/view'
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '[DIFFERENT UNIQUE KEY]',
            'csrfParam' => '_backendCSRF',
        ],
		'formatter' => [
			'class' => 'yii\i18n\Formatter',
			'nullDisplay' => '',
		],
    ],
    'params' => $params,
];
