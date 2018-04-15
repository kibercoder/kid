<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class ProfileEditAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        //'css/profile_pages.less',
        //'css/profile.css',
        'css/window_kidwork.css',
        'css/style.css',
        'css/edit.css',       
    ];
    public $js = [
        //'js/profile.js',
        'js/handler_update.js',
        'js/window_kidwork.js',
        'js/script.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];

}
