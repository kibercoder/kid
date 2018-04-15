<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class TournamentsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'css/style.less',
        'css/jquery.custom-scroll.css',
        'css/tablo.less',
        'css/tournament.less',
        'css/window_tournament.css',
    ];
    public $js = [
        'js/window_tournament.js',
        'js/jquery.custom-scroll.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
       // 'yii\bootstrap\BootstrapAsset',
    ];

}
