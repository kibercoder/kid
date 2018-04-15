<?php

class Chat{

    public function __construct() {
        $this->db = Helper::getDb();
    }

    /**
     * Функция срабатывает когда клиент открывает соединение
     * @param integer $user_id
     * @return string|null если функция что либо возращает это будет послано обратно, тому же пользователю который инициализировал подключение
     */
    public function onConnect($user_id){
        $command = $this->db->createCommand('SELECT username FROM user WHERE id = '.$user_id);
        $username = $command->queryScalar();
        echo 'Login '.$username."\n"; 
        return $username;
    }

    /**
     *  Функция срабатывает когда клиент закрыл соединение
     * @param array $user массив содеожит данные о текущем закрытом соединение а именно ключи 'user' => $user_id, 'connection' => $connection, 'task' => $_GET['task']
     * функция ни чего не должна возращать так как клиент уже отсоединился
     */
    public function onClose($user){
        $command = $this->db->createCommand('SELECT username FROM user WHERE id = '.$user['user_id']);
        $username = $command->queryScalar();
        echo 'Logout '.$username."\n"; 
    } 

    /**
     *  Функция срабатывает когда клиент послал сообщение (Главная функция обработки данных)
     * @param array $users массив массов объектов пользовталей содеожит данные о текущем закрытом соединение а именно ключи 'user' => $user_id, 'connection' => $connection, 'task' => $_GET['task']
     * @param array $user массив содеожит данные о текущем соединение а именно ключи 'user' => $user_id, 'connection' => $connection, 'task' => $_GET['task']
     * @param mixed data объект данных посланный пользователем
     * @return array|null если функция возращает массив там должно быть 2 ключа 'connection' идентификатор соединения и 'message' само сообщение, прм этом если нужно послать обратно объект нужно его самому упаковать json_encode
     */
    public function onMessage($users, $user, $data){
        $command = $this->db->createCommand('SELECT username FROM user WHERE id = '.$data->user);
        $toUsername = $command->queryScalar();
        $command = $this->db->createCommand('SELECT username FROM user WHERE id = '.$user['user_id']);
        $fromUsername = $command->queryScalar();      
        echo 'Sent from '.$fromUsername.' to '.$toUsername." message ".$data->message." \n"; 
        $keys = Helper::getKeys($users, 'user_id', $data->user_id);
        // соединение того пользователя кому нужно послать сообщение $users[$key]['connection']  
        if(count($keys)){ 
            $return = [];
            foreach($keys as $key){
                $return[] = [
                    'connection' => $users[$key]['connection'],
                    'message'=>json_encode($message)
                ]; 
            }   
            return $return;
        } 
    }   



}