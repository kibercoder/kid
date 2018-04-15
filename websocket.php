<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
require_once __DIR__ . '/websocket/helper.php';
use Workerman\Worker;

// массив для связи соединения пользователя и необходимого нам параметра
$users = [];

// создаём ws-сервер, к которому будут подключаться все наши пользователи
$ws_worker = new Worker("websocket://83.69.226.66:2346");
// создаём обработчик, который будет выполняться при запуске ws-сервера
/*$ws_worker->onWorkerStart = function() use (&$users)
{
    // создаём локальный tcp-сервер, чтобы отправлять на него сообщения из кода нашего сайта
    $inner_tcp_worker = new Worker("tcp://127.0.0.1:1234");
    // создаём обработчик сообщений, который будет срабатывать,
    // когда на локальный tcp-сокет приходит сообщение
    $inner_tcp_worker->onMessage = function($connection, $data) use (&$users) {
        $data = json_decode($data); echo $data->message."\n";
        // отправляем сообщение пользователю по user_id
        if (isset($users[$data->user])) {
            $webconnection = $users[$data->user];
            $webconnection->send($data->message);
        }
    };
    $inner_tcp_worker->listen();
};*/

$ws_worker->onConnect = function($connection) use (&$users)
{
    $connection->onWebSocketConnect = function($connection) use (&$users)
    {
        //проверяем на наличие параметра task
        if(isset($_GET['task']) && !empty($_GET['task'])){;
            // при подключении нового пользователя добавляем данные о нем в массив пользователей
            $user_id = (int)$_GET['user_id'];
            $users[] = ['user_id' => $user_id, 'connection' => $connection, 'task' => $_GET['task']];

            $task = ucwords($_GET['task']);//echo __DIR__.'/websocket/'.$task.'.php'."\n";
            if(file_exists(__DIR__.'/websocket/'.$task.'.php')){
                require_once __DIR__.'/websocket/'.$task.'.php';
                $taskObject = new $task();
                if(method_exists($taskObject , 'onConnect')){
                    $result = $taskObject->onConnect($user_id);
                    if($result){
                        $connection->send($result);
                    }
                }
            }
        }
        // вместо $_GET['user'] -параметра можно также использовать параметр из cookie, например $_COOKIE['advanced-frontend']
    };
};

$ws_worker->onClose = function($connection) use(&$users)
{
    // удаляем параметр при отключении пользователя
    $key = Helper::getKey($users, 'connection', $connection);
    //Запускаем событие onClose
    if(isset($users[$key]['task']) && !empty($users[$key]['task'])){
        //echo 'Logout '.$users[$key]['user']."\n";
        $task = ucwords($users[$key]['task']);//echo __DIR__.'/websocket/'.$task.'.php'."\n";
        if(file_exists(__DIR__.'/websocket/'.$task.'.php')){
            require_once __DIR__.'/websocket/'.$task.'.php';
            $taskObject = new $task();
            if(method_exists($taskObject , 'onClose')){
                $taskObject->onClose($users[$key]);
            }
        }
    } 
    unset($users[$key]);   
};

// Emitted when data received
$ws_worker->onMessage = function($connection, $data)  use(&$users)
{
    $data = json_decode($data);
    $key = Helper::getKey($users, 'connection', $connection);
    // отправляем сообщение пользователю по user_id
    if(isset($users[$key]['task']) && !empty($users[$key]['task'])){
        $task = ucwords($users[$key]['task']);
        if(file_exists(__DIR__.'/websocket/'.$task.'.php')){
            require_once __DIR__.'/websocket/'.$task.'.php';
            $taskObject = new $task();
            if(method_exists($taskObject , 'onConnect')){
                $results = $taskObject->onMessage($users, $users[$key], $data);
                if(count($results)){ 
                    foreach($results as $result){
                        if($result['connection']){
                            $result['connection']->send($result['message']);
                        }
                    }
                }
            }
        }
    }    
};

// Run worker
Worker::runAll();