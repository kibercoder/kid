<?php

namespace frontend\controllers;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\Game;
use frontend\models\Settle;
use common\models\User;

class GameController extends \yii\web\Controller
{
 
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }   
    
    public function actionIndex()
    {
$html = '
<html><head><title>WebSocket</title>
<style type="text/css">
html,body {
    font:normal 0.9em arial,helvetica;
}
#log {
    width:600px; 
    height:300px; 
    border:1px solid #7F9DB9; 
    overflow:auto;
}
#msg {
    width:400px;
}
</style>
<script type="text/javascript">
var socket;

function init() {
    var host = "ws://83.69.226.66:2346?task=game&user_id='.\Yii::$app->user->identity->id.'"; // SET THIS TO YOUR SERVER
    try {
        socket = new WebSocket(host);
        log("WebSocket - status "+socket.readyState);
        socket.onopen    = function(msg) { 
                                log("Welcome - status "+this.readyState); 
                            };
        socket.onmessage = function(msg) { 
                                log("Received: "+msg.data); 
                            };
        socket.onclose   = function(msg) { 
                                log("Disconnected - status "+this.readyState); 
                            };
    }
    catch(ex){ 
        log(ex); 
    }
}


function sendEasy(){
    var msg = JSON.stringify({ action: "easy", complexity: "easy",name:"producer"});
    sendCommand(msg);
}
function sendStart(){
    var msg = JSON.stringify({ action: "start", complexity: "easy",name:"producer"});
    sendCommand(msg);
}
function sendEndSuccess(){
    var msg = JSON.stringify({ action: "end", complexity: "easy",name:"producer" ,result: 1,hash:"123435cvbvcn"});
    sendCommand(msg);
}
function sendEndFail(){
    var msg = JSON.stringify({ action: "end", complexity: "easy",name:"producer" ,result: 0,hash:"123435cvbvcn"});
    sendCommand(msg);
}
function sendCommand(msg){
    try { 
        console.log(msg);     
        socket.send(msg); 
        log("Sent: "+msg); 
    } catch(ex) { 
        log(ex); 
    }
}
function quit(){
    if (socket != null) {
        log("Goodbye!");
        socket.close();
        socket=null;
    }
}

function reconnect() {
    quit();
    init();
}

// Utilities
function $(id){ return document.getElementById(id); }
function log(msg){ $("log").innerHTML+="<br>"+msg; }
function onkey(event){ if(event.keyCode==13){ send(); } }
</script>

</head>
<body onload="init()">
<h3>WebSocket v2.00</h3>
<div id="log"></div>
<button onclick="quit()">Quit</button>
<button onclick="reconnect()">Reconnect</button>
<button onclick="sendEasy()">sendEasy</button>
<button onclick="sendStart()">sendStart</button>
<button onclick="sendEndSuccess()">sendEndSuccess</button>
<button onclick="sendEndFail()">sendEndFail</button>
</body>
</html>
';
echo $html;exit();      
        
        return $this->redirect(['site/index']);
    }

    public function actionProducer()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        $user = User::findOne(\Yii::$app->user->identity->id);
        $game = new Game();
        if($game->checkGameStart()){
            $this->layout = 'game';     
            return $this->render('producer');
        }else{

            //тут уточнить что именно нужно показывать елси ранее начаная игра еще не была закончена
            $lastGame = $game->getLastGameStart();
            echo '<pre>'.print_r($lastGame, true).'</pre>';die();
        }
    }

    public function actionJournalist()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }  
        $this->layout = 'game';     
        return $this->render('journalist');
    }

    public function actionSettle(){
        $request = Yii::$app->request;
        $name = $request->get('name');
        if(!$name){
            throw new yii\web\HttpException(400 ,'Параметр name не найден');
        } 
        $settle = new Settle();
        $settle->user_id = \Yii::$app->user->identity->id;
        $settle->name = $name;
        if($settle->save()){
            return $this->redirect(['city/filmstudio']);
        }else{
            throw new yii\web\ServerErrorHttpException($settle->getError()); 
        }
    }

}
