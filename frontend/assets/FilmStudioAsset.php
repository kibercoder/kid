<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class FilmStudioAsset extends AssetBundle
{
    public $basePath = '@app/locations/';
    public $baseUrl = '/locations/';
    
    public $css = [
        //'css/style.css',
        //'css/tickets.css',
    ];
    public $js = [
        //'games/producer/lib.min.js',
        //'games/producer/app.min.js',
    ];
    public $depends = [
        //'yii\web\YiiAsset',
       //'yii\bootstrap\BootstrapAsset',
    ];

}
