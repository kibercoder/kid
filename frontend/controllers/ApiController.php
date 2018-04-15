<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\Game;
use common\models\User;

class ApiController extends \yii\web\Controller
{
    public $defaultAction = 'index';
    
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
	var host = "ws://83.69.226.66:2346?task=chat&user_id='.\Yii::$app->user->identity->id.'"; // SET THIS TO YOUR SERVER
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
	$("msg").focus();
}

function send(){
	var txt,msg;
	txt = $("msg");
	msg = txt.value;
	if(!msg) { 
		alert("Message can not be empty"); 
		return; 
	}
	txt.value="";
	txt.focus();
	try { 
  console.log(JSON.stringify({ user: 10, message:msg }));     
		socket.send(JSON.stringify({ user: 10, message:msg })); 
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
<input id="msg" type="textbox" onkeypress="onkey(event)"/>
<button onclick="send()">Send</button>
<button onclick="quit()">Quit</button>
<button onclick="reconnect()">Reconnect</button>
</body>
</html>
';
echo $html;exit();
        $request = Yii::$app->request;
        if ($request->isAjax) { /* the request is an AJAX request */ }
        //$post = $request->post();
        $user = User::findOne(\Yii::$app->user->identity->id);
        $game = new Game();
        //$post = Yii::$app->request->post();
        $game->user_id = $user->id;
        $game->name = $request->get('name');
        $game->action = $request->get('action');
        $game->complexity = $request->get('complexity');
        $game->hash = $request->get('hash');
        $game->created = time();

        //для акшена end сделать проверку того что такая игра действительно была начата
        if($game->action == 'end'){
            if (!$game->checkStartGameEarly($game->hash)){
                echo json_encode(['result' => false, 'msg' => ['Попытка не санкционированого завершения игры']]);
                exit(); 
            }
        }

        if ($game->save()) {
            //тут добавить проверку на то что если было сыгран 10 игр на режиме трудно или кошмар, то давать полльзователю звезжу и карточку профессии
            //а так же начисление коинов пользователю
            echo json_encode(['result' => true]);//array(  'result' => true,  )
        }else{ 
            echo json_encode(['result' => false, 'msg'  => $game->errors]);
            /*
            array(
                'result' => false,
                'msg' => 
                 array (
                   0 => 'Необходимо заполнить «название игры».',
                 ),
             )
             */
        }
        exit();
    }
    
    public function actionEasy()
    {
        $request = Yii::$app->request;
        $name = $request->get('name');
        if(!$name){
            echo json_encode(['result' => false, 'msg'  => ['Не передан обязательный параметр name']]);
            exit();
        }
        $game = new Game();
        if ($game->checkBlockEasy($name)) {
            echo json_encode(['result' => true]);//array(  'result' => true,  )
        }else{
            echo json_encode(['result' => false]);//array(  'result' => false,  )
        }
        exit();
    }

    public function actionEnd()
    {
        return $this->render('end');
    }

    public function actionStart()
    {

    }

    public function actionTop()
    {
        return $this->render('top');
    }

}
