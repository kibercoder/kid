<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [

    'language' => 'ru-RU',
    'sourceLanguage' => 'ru-RU',
    'timeZone' => 'Europe/Moscow',

    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],

    /*'on beforeRequest' => function ($event) {
        if(!Yii::$app->request->isSecureConnection){
            $url = Yii::$app->request->getAbsoluteUrl();
            $url = str_replace('http:', 'https:', $url);
            Yii::$app->getResponse()->redirect($url);
            Yii::$app->end();
        }
    },*/

    'controllerNamespace' => 'frontend\controllers',
    'language' => 'ru-RU',
    'components' => [
        'eauth' => [
            'class' => 'nodge\eauth\EAuth',
            'popup' => true, // Use the popup window instead of redirecting.
            'cache' => false, // Cache component name or false to disable cache. Defaults to 'cache' on production environments.
            'cacheExpire' => 0, // Cache lifetime. Defaults to 0 - means unlimited.
            'httpClient' => [
                // uncomment this to use streams in safe_mode
                //'useStreamsFallback' => true,
            ],
            'services' => [ // You can change the providers and their classes.
                /*'google' => [
                    // register your app here: https://code.google.com/apis/console/
                    'class' => 'nodge\eauth\services\GoogleOAuth2Service',
                    'clientId' => '...',
                    'clientSecret' => '...',
                    'title' => 'Google',
                ],
                'twitter' => [
                    // register your app here: https://dev.twitter.com/apps/new
                    'class' => 'nodge\eauth\services\TwitterOAuth1Service',
                    'key' => '...',
                    'secret' => '...',
                ],
                'yandex' => [
                    // register your app here: https://oauth.yandex.ru/client/my
                    'class' => 'nodge\eauth\services\YandexOAuth2Service',
                    'clientId' => '...',
                    'clientSecret' => '...',
                    'title' => 'Yandex',
                ],
                'facebook' => [
                    // register your app here: https://developers.facebook.com/apps/
                    'class' => 'nodge\eauth\services\FacebookOAuth2Service',
                    'clientId' => '...',
                    'clientSecret' => '...',
                ],
                'yahoo' => [
                    'class' => 'nodge\eauth\services\YahooOpenIDService',
                    //'realm' => '*.example.org', // your domain, can be with wildcard to authenticate on subdomains.
                ],
                'linkedin' => [
                    // register your app here: https://www.linkedin.com/secure/developer
                    'class' => 'nodge\eauth\services\LinkedinOAuth1Service',
                    'key' => '...',
                    'secret' => '...',
                    'title' => 'LinkedIn (OAuth1)',
                ],
                'linkedin_oauth2' => [
                    // register your app here: https://www.linkedin.com/secure/developer
                    'class' => 'nodge\eauth\services\LinkedinOAuth2Service',
                    'clientId' => '...',
                    'clientSecret' => '...',
                    'title' => 'LinkedIn (OAuth2)',
                ],
                'github' => [
                    // register your app here: https://github.com/settings/applications
                    'class' => 'nodge\eauth\services\GitHubOAuth2Service',
                    'clientId' => '...',
                    'clientSecret' => '...',
                ],
                'live' => [
                    // register your app here: https://account.live.com/developers/applications/index
                    'class' => 'nodge\eauth\services\LiveOAuth2Service',
                    'clientId' => '...',
                    'clientSecret' => '...',
                ],
                'steam' => [
                    'class' => 'nodge\eauth\services\SteamOpenIDService',
                    //'realm' => '*.example.org', // your domain, can be with wildcard to authenticate on subdomains.
                    'apiKey' => '...', // Optional. You can get it here: https://steamcommunity.com/dev/apikey
                ],
                'instagram' => [
                    // register your app here: https://instagram.com/developer/register/
                    'class' => 'nodge\eauth\services\InstagramOAuth2Service',
                    'clientId' => '...',
                    'clientSecret' => '...',
                ],
                'vkontakte' => [
                    // register your app here: 
                    //https://vk.com/editapp?act=create&site=1
                    //https://vk.com/editapp?id=6364229&section=options
                    'class' => 'nodge\eauth\services\VKontakteOAuth2Service',
                    'clientId' => '6364229',
                    'clientSecret' => 'Rw6rBJhWIYpqQ1OTyGNf',
                    'title' => ''
                ],
                
                'mailru' => [
                    // register your app here: http://api.mail.ru/sites/my/add
                    'class' => 'nodge\eauth\services\MailruOAuth2Service',
                    'clientId' => '...',
                    'clientSecret' => '...',
                ],
                */

                'vkontakte' => [     'class' => 'frontend\components\oauth\VKontakteOAuth2Service',
                    'clientId' => '6364229',
                    'clientSecret' => 'Rw6rBJhWIYpqQ1OTyGNf',
                    'title' => '',
                ],

                'odnoklassniki' => [
                    // register your app here: http://dev.odnoklassniki.ru/wiki/pages/viewpage.action?pageId=13992188
                    // ... or here: http://www.odnoklassniki.ru/dk?st.cmd=appsInfoMyDevList&st._aid=Apps_Info_MyDev
                    //https://ok.ru/vitrine/myuploaded
                    //https://apiok.ru/ext/oauth/
                    'class' => 'nodge\eauth\services\OdnoklassnikiOAuth2Service',
                    'clientId' => '1262573568',
                    'clientSecret' => '109D4AC64C8E1C85147BDDB2',
                    'clientPublic' => 'CBAJFCEMEBABABABA',
                    'title' => '',
                ],
            ],
        ],

        'i18n' => [
            'translations' => [
                'eauth' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@eauth/messages',
                ],

                'yii2mod.comments' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/comments/messages',
                    'sourceLanguage' => 'ru',
                ],

                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //if basic application, set @app/messages
                    'basePath' => '@frontend/messages', 
                    'sourceLanguage' => 'ru',
                    'fileMap' => [
                        //'main' => 'main.php',
                    ],
                ],

            ],
        ],



        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => ''
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
            'class' => 'yii\web\DbSession',
            'writeCallback' => function ($session) {
                return [
                   'user_id' => Yii::$app->user->id,
                   'last_write' => date('Y-m-d H:i:s',time()),
               ];
            },            
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
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                '/' => 'site/index',
                'about' => 'site/about',
                'contact' => 'site/contact',
                'login' => 'site/login',
                'logout' => 'site/logout',
                'captcha' => 'site/captcha',
                'signup' => 'site/signup',
                'handler' => 'site/handler',
                'request-password-reset' => 'site/request-password-reset',
                'reset-password' => 'site/reset-password',
                'tournaments' => 'tournament/index',
                'get-tour' => 'tournament/get-tour',
                'map' => 'tournament/map',

                '<controller:\w+>' => '<controller>/index',
                //'user'=>'user/index',
                

                '<action>'=>'site/<action>',

                'login/<service:google|facebook|etc>' => 'site/login',
                'user/<id:\d+>'=>'user/index',
                'user/dialog/<id:\d+>'=>'user/dialog',
                'game/<action:\w+>', 'game/<action>',
                '<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
            ],
        ],
        'assetManager' => [
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets',


            'converter'=> [
                'class'=> 'nizsheanez\assetConverter\Converter',
                'force'=> true, // true : If you want convert your sass each time without time dependency
                'destinationDir' => 'compiled', //at which folder of @webroot put compiled files
                'parsers' => [
                    'sass' => [ // file extension to parse
                        'class' => 'nizsheanez\assetConverter\Sass',
                        'output' => 'css', // parsed output file type
                        'options' => [
                            'cachePath' => '@app/runtime/cache/sass-parser' // optional options
                        ],
                    ],
                    'scss' => [ // file extension to parse
                        'class' => 'nizsheanez\assetConverter\Sass',
                        'output' => 'css', // parsed output file type
                        'options' => [] // optional options
                    ],
                    'less' => [ // file extension to parse
                        'class' => 'nizsheanez\assetConverter\Less',
                        'output' => 'css', // parsed output file type
                        'options' => [
                            'auto' => true, // optional options
                        ]
                    ]
                ]
            ],

            //Отключаем стили для модуля комментарии
            'bundles' => [
                'yii2mod\comments\CommentAsset' => [
                    'sourcePath' => null,   // do not publish the bundle
                    'js' => ['js/comment.js'],
                    'css' => []
                ],
            ],

            /*'bundles' => require(__DIR__ . '/assets.php'),
            'converter'=> [
                'class'=>'nizsheanez\assetConverter\Converter',
            ]

            'converter' => [
                'class' => 'yii\web\AssetConverter',
                'commands' => [
                    'less' => ['css', 'lessc {from} {to} --no-color'],
                ],
            ],*/

        ],  

        // (optionally) you can configure logging
        /*'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => '@app/runtime/logs/eauth.log',
                    'categories' => ['nodge\eauth\*'],
                    'logVars' => [],
                ],
            ],
        ],*/
        
    ],

    'modules' => [
        'comment' => [
            'class' => 'yii2mod\comments\Module',
            'enableInlineEdit' => true,
            'controllerMap' => [
                'default' => [
                    'class' => 'frontend\controllers\CommentController',

                ]
            ]

        ],

        'gii' => [
            'class' => 'yiisoft\gii\Module',
            'as access' => [ // if you need to set access
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'], // only admin
                        //'roles' => ['@'] // all auth users
                    ],
                ]
            ],
        ],

    ],

    'params' => $params,
];
