<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class SignupAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'css/signup.less',
        'css/window_kidwork.css'
    ];
    public $js = [
        'js/window_kidwork.js',
        'js/handler.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
       // 'yii\bootstrap\BootstrapAsset',
    ];

}
