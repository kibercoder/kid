<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AcademyAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.6.0/tiny-slider.css',
        'css/style.css',
        'css/academy.css',
    ];
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.6.0/min/tiny-slider.js',
        'js/academy_slider.js',
        'js/script.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
       //'yii\bootstrap\BootstrapAsset',
    ];

}
