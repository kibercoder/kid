<?php

class Game{

    public function __construct() {
        $this->db = Helper::getDb();
    }

    /**
     * Функция срабатывает когда клиент открывает соединение
     * @param integer $user_id
     * @return string|null если функция что либо возращает это будет послано обратно,тому же пользователю который инициализировал подключение
     */
    public function onConnect($user_id){
        $command = $this->db->createCommand('SELECT username FROM user WHERE id = '.$user_id);
        $username = $command->queryScalar();
        echo 'Game Login '.$username."\n"; 
        //return $username;
    }

    /**
     *  Функция срабатывает когда клиент закрыл соединение
     * @param array $user массив содеожит данные о текущем закрытом соединение а именно ключи 'user' => $user_id, 'connection' => $connection, 'task' => $_GET['task']
     * функция ни чего не должна возращать так как клиент уже отсоединился
     */
    public function onClose($user){
        $result = $this->db->createCommand()->insert('game', [
            'user_id' => $user['user_id'],
            'name' => '',
            'action' => 'exit',
            'created' => time()
        ])->execute();
        echo 'Logout '.$user['user_id']."\n"; 
        return json_encode(['result'=> $result]);

    } 

    /**
     *  Функция срабатывает когда клиент послал сообщение (Главная функция обработки данных)
     * @param array $users массив массов объектов пользовталей содеожит данные о текущем закрытом соединение а именно ключи 'user' => $user_id, 'connection' => $connection, 'task' => $_GET['task']
     * @param array $user массив содеожит данные о текущем соединение а именно ключи 'user' => $user_id, 'connection' => $connection, 'task' => $_GET['task']
     * @param mixed data объект данных посланный пользователем
     * @return array|null если функция возращает массив там должно быть 2 ключа 'connection' идентификатор соединения и 'message' само сообщение, прм этом если нужно послать обратно объект нужно 'message' упаковать json_encode
     */
    public function onMessage($users, $user, $data){
        print_r($data);
        switch($data->action){
            case 'easy':
            $easyCount = $this->db->createCommand('SELECT COUNT([[id]]) FROM {{game}} WHERE [[user_id]] = :user_id AND [[name]] = :name AND [[complexity]] = :complexity' )
                        ->bindValue(':user_id',$user['user_id'])
                        ->bindValue(':name', $data->name)
                        ->bindValue(':complexity', 'easy')
                        ->queryScalar();
            $result = ($easyCount < 10 ) ? 0 : 1;        
            return [
                [
                'connection' => $user['connection'],
                'message'=>json_encode(['result'=> $result])
                ]
            ];
        break;          
            case 'start':
                $hash = md5(uniqid(rand(),1));
                $this->db->createCommand()->insert('game', [
                    'user_id' => $user['user_id'],
                    'name' => $data->name,
                    'complexity' => $data->complexity,
                    'action' => 'start',
                    'hash' => $hash,
                    'created' => time()
                ])->execute();
                $exitUrl = $this->getExitUrl($data->name);
                return [
                    [
                    'connection' => $user['connection'],
                    'message'=>json_encode(['hash'=> $hash,'exitUrl' => $exitUrl])
                    ]
                ];              
            break;
            case 'end':
                $result = $this->db->createCommand()->insert('game', [
                    'user_id' => $user['user_id'],
                    'name' => $data->name,
                    'complexity' => $data->complexity,
                    'action' => 'end',
                    'hash' => $data->hash,
                    'created' => time()
                ])->execute();
                $endUrl = $this->getExitUrl($data->name);

    //Добавить зачисление коинтов за успешно завершенную игру
    //Добавить проверку на то что было сыграно 10 игр на сложном режиме и выдавать за это карточку профессии, а так же проверять потом на каждые 50 игор на сложном и тоже выдавать карточки
                return [
                    [
                    'connection' => $user['connection'],
                    'message'=>json_encode(['endUrl'=> $endUrl])
                    ]
                ];
            break;           
        }
    }   


    public function getExitUrl($name){
        switch($name){
            case 'producer':
                $exitUrl = 'city/filmstudio';
            break;
            case 'journalist':
                $exitUrl = 'city/redaction';
            break;           
        }
        return $exitUrl;
    }

}