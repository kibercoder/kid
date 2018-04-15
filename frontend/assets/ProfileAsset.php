<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class ProfileAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'css/profile_pages.less',
        'css/profile.css',
        'css/style.css',
        'css/personal.css',
    ];
    public $js = [
        'js/notify.min.js',
        'js/profile.js',
        'js/new_comment.js',
        'js/script.js',
        'js/profile_ws.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
       //'yii\bootstrap\BootstrapAsset',
    ];

}
