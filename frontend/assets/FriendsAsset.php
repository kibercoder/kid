<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class FriendsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'css/style.css',
        'css/friends.css',
    ];
    public $js = [
        'js/notify.min.js',
        'js/script.js',
        'js/friends_ws.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
       //'yii\bootstrap\BootstrapAsset',
    ];

}
