<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'sms' => [
            'class'    => 'ladamalina\smsc\Smsc',
            'login'     => 'rdbx',  // login
            'password'   => 'ea1c2o1m', // plain password or lowercase password MD5-hash
            'post' => true, // use http POST method
            'https' => true,    // use secure HTTPS connection
            'charset' => 'utf-8',   // charset: windows-1251, koi8-r or utf-8 (default)
            'debug' => false,    // debug mode
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.yandex.ru',
                'username' => 'kpkurzhum1@yandex.ru',
                'password' => 'mwcgbaamgdztpaiu',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => ''
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                '/' => 'client/index',
                '/site/logout' => 'site/logout',
                '/site/login' => 'site/login',
                '/site/signup'                 => 'site/signup',
                '/site/signup/emailcheck'      => 'site/emailcheck',
                '/site/verify-email'           => 'site/verify-email',
                '/site/request-password-reset' => 'site/request-password-reset',
                '/site/reset-password'         => 'site/reset-password',

                '/client' => 'client/index',
                '/client/view/<id:\d+>' => 'client/view',
                '/client/create' => 'client/create',
                '/client/update/<id:\d+>' => 'client/update',
                '/client/delete/<id:\d+>' => 'client/delete',

                '/order' => 'order/index',
                '/order/view/<id:\d+>' => 'order/view',
                '/order/create' => 'order/create',
                '/order/update/<id:\d+>' => 'order/update',
                '/order/delete/<id:\d+>' => 'order/delete',

                '/qrcode/<url>' => 'order/qrcode',
                '/activate/<url>' => 'order/activate',

                '/user' => 'user/index',
                '/user/view/<id:\d+>' => 'user/view',
                '/user/create' => 'user/create',
                '/user/update/<id:\d+>' => 'user/update',
                '/user/delete/<id:\d+>' => 'user/delete',
            ],
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
