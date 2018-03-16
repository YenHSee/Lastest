<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'Application Name',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '8hw8qfw4hD0lj_c54Lou2eL_d5BdZTOe',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest'],
        ],
        'mandrill' => [
            'class' => 'nickcv\mandrill\Mailer',
            'api_key' => 'adeebd1008c3aa1193a8504e313ace43-us12',
            'company_logo' => '',
            'company_name' =>'',
            'from_name' => 'yhs',
            'from_email' => 'seeyhong@hotmail.com',
            'reply_to_email' => '',
            'message' => '',
        ],
        'mailer' => [
            //'class' => 'yii\swiftmailer\Mailer',
            'class' => 'nickcv\mandrill\Mailer',
            'apikey' => 'adeebd1008c3aa1193a8504e313ace43-us12',
            //'userMandrillTemplates' => true,
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            // 'transport' => [
            //     'class' => 'Swift_SmtpTransport',
            //     'host' => 'mail.lol.co.tz',
            //     'username' => 'seeyh-ja14@student.tarc.edu.my',
            //     'password' => 'qwqweqwerqw12',
            //     'port' => '25', 
            //     'encryption' => 'tls', //depends if you need it
            //     ],
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
        'db' => $db,
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
