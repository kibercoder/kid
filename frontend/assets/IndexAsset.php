<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class IndexAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'css/main_page.less',
        'css/ballon.css'
    ];
    public $js = [
        'js/mapper.full.js',
        'js/app.bus.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
       // 'yii\bootstrap\BootstrapAsset',
    ];

}
