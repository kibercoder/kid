<?php

class User{

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
        echo 'User Login '.$username."\n"; 
        //return $username;
    }

    /**
     *  Функция срабатывает когда клиент закрыл соединение
     * @param array $user массив содеожит данные о текущем закрытом соединение а именно ключи 'user' => $user_id, 'connection' => $connection, 'task' => $_GET['task']
     * функция ни чего не должна возращать так как клиент уже отсоединился
     */
    public function onClose($user){
        echo 'Logout '.$user['user_id']."\n"; 
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
        $toUsername = $this->db->createCommand('SELECT username FROM user WHERE id = '.$data->user_id)->queryScalar();
        $fromUsername = $this->db->createCommand('SELECT username FROM user WHERE id = '.$user['user_id'])->queryScalar();           
        switch($data->action){
            case 'message':
                $insertData = [
                    'to_user_id' => $data->user_id,
                    'from_user_id' => $user['user_id'],
                    'text' => $data->message,
                ];
                if(isset($data->file)){
                    $insertData['file'] = $this->saveFile($data);
                }
                $this->db->createCommand()->insert('userMessage', $insertData)->execute(); 
                            
                echo 'Sent from '.$fromUsername.' to '.$toUsername." message ".$data->message." \n"; 
                $message = ['message'=> $data->message];

            break;    

            case 'gift':
                $gift = $this->db->createCommand('SELECT * FROM gift WHERE id = '.$data->gift_id)->queryOne();

//Дописать списание средств со счета пользователя отправителя подарка                

                $insertData = [
                    'to_user_id' => $data->user_id,
                    'from_user_id' => $user['user_id'],
                    'gift_id' => $data->gift_id,
                ];
                $this->db->createCommand()->insert('userGift', $insertData)->execute();               
                echo 'Sent from '.$fromUsername.' to '.$toUsername." gift ".$data->gift_id." \n";
                $message = ['add_gift'=> $gift['url']];         
            break;

            case 'add-friend':
                $checkSubmitted = $this->db->createCommand('SELECT COUNT(*) FROM friend WHERE from_user_id = '.$data->user_id.' AND to_user_id = '.$user['user_id'])->queryScalar(); 
                if(!$checkSubmitted) {           
                    $insertData = [
                        'to_user_id' => $data->user_id,
                        'from_user_id' => $user['user_id'],
                    ];
                    $this->db->createCommand()->insert('friend', $insertData)->execute();               
                    echo 'Friend from '.$fromUsername.' to '.$toUsername."\n";
                    $message = ['notice'=> 'Получен запрос на дружбу от пользователя '.$fromUsername]; 
                }else{
                    $acceptData = [
                        'to_user_id' => $user['user_id'],
                        'from_user_id' => $data->user_id,
                    ];
                    $this->db->createCommand()->update('friend', ['accept' => 1], $acceptData)->execute();  
                               
                    echo 'Accept friend from '.$fromUsername.' to '.$toUsername."\n";
                    $message = ['notice'=> 'Запрос на дружбу от пользователя '.$fromUsername.' был подвержден'];                     
                }        
            break; 
            
            case 'remove-submitted':               
                $deleteData = [
                    'to_user_id' => $data->user_id,
                    'from_user_id' => $user['user_id'],
                ];
                $this->db->createCommand()->delete('friend', $deleteData)->execute();               
                echo 'Remove submitted from '.$fromUsername.' to '.$toUsername."\n";
                $message = ['notice'=> 'Отмена запроса на дружбу от пользователя '.$fromUsername];         
            break;
 
            case 'remove-friend':               
                $updateData = [
                    'to_user_id' => $user['user_id'],
                    'from_user_id' => $data->user_id,
                ];
                $this->db->createCommand()->update('friend', ['accept' => 0], $acceptData)->execute();  
                echo 'Remove friend from '.$fromUsername.' to '.$toUsername."\n";
                $message = ['notice'=> 'Удаление подтверждения запроса на дружбу от пользователяп '.$fromUsername];      
            break;           
            case 'accept-friend':               
                $acceptData = [
                    'to_user_id' => $user['user_id'],
                    'from_user_id' => $data->user_id,
                ];
                $this->db->createCommand()->update('friend', ['accept' => 1], $acceptData)->execute();  
                           
                echo 'Accept friend from '.$fromUsername.' to '.$toUsername."\n";
                $message = ['notice'=> 'Запрос на дружбу от пользователя '.$fromUsername.' был подвержден'];         
            break;            
          
        }
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


    public function saveFile($data){
        //print_r($data);  
        $img = substr($data->fileData, (strpos($data->fileData,'base64,')+7));
        //echo 'img '.$img."\n";
        $fileData = base64_decode($img);
        $pathParts = pathinfo($data->file);
        $fileName = uniqid().'.'.$pathParts['extension'];
        $filePath = dirname( dirname(__FILE__) ).'/frontend/web/upload/message/'.$fileName;
        //echo 'filePath '.$filePath."\n";
        if(file_put_contents($filePath, $fileData)){
            return 'web/upload/message/'.$fileName;
        }
    }

}