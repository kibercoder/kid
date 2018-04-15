<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class PaymentAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.6.0/tiny-slider.css',
        'css/style.css',
        'css/academy.css',
        'css/payment.css',
    ];
    public $js = [
        'js/script.js',
        'js/inputmask.js',
        'js/payment.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
       //'yii\bootstrap\BootstrapAsset',
    ];

}
