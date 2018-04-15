<?php
use yii\helpers\Html;
use common\models\User;
 ?>
<head>
    <meta charset="<?= Yii::$app->charset ?>">

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!--meta name="viewport" content="width=device-width, initial-scale=1"-->

    <meta http-equiv="Content-Language" content="ru" />

    <?= Html::csrfMetaTags() ?>

    <title><?= Html::encode($this->title) ?></title>

    <link rel="icon" href="/favicon.ico" type="image/x-icon" />

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />

    <meta name="description" content="" />

    <meta name="keywords" content="" />

    <script type="text/javascript">
        window.onload = function() {
            if(screen.width < 600){
                $("head").append('<link rel="stylesheet" type="text/css" href="/css/touches.css" />'); 
            }
        }
    </script>

    <script type="text/javascript">
        var socket;

        function init() {
            var host = "ws://83.69.226.66:2346?task=user&user_id=<?= \Yii::$app->user->identity->id;?>";
            try {
                socket = new WebSocket(host);
                console.log("WebSocket - status "+socket.readyState);
            }
            catch(ex){ 
                console.log(ex); 
            }
        }
        init();
        function sendEnd(){
            var msg = JSON.stringify({ action: "end", complexity: "easy",name:"producer" ,hash:"123435cvbvcn"});
            sendCommand(msg);
        }
        function sendCommand(msg){
            try { 
                console.log(msg);     
                socket.send(msg);  
            } catch(ex) { 
                log(ex); 
            }
        }       
    </script>

    <?php $this->head() ?>

</head>