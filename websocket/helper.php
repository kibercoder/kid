<?php

class Helper{
    private static $instance = null;

    public static function getDb() {
        if (null === self::$instance){
            $dbConfig = require_once getcwd() .'/common/config/main-local.php';
            //print_r($dbConfig);         
            $db = new yii\db\Connection([
                'dsn' => $dbConfig['components']['db']['dsn'],
                'username' => $dbConfig['components']['db']['username'],
                'password' => $dbConfig['components']['db']['password'],
                'charset' => $dbConfig['components']['db']['charset'],
            ]);
            $db->open();
            self::$instance = $db;
        }

        return  self::$instance;
    }

    public static function getKey($users, $searchKey, $value) {
        foreach($users as $key => $user){
            //if($searchKey == 'user_id') echo 'user[$searchKey] '.$user[$searchKey].' value '.$value." \n"; 
            if($user[$searchKey] === $value){
                return  $key;
            }
        }
    }

    public static function getKeys($users, $searchKey, $value) {
        $keys = [];
        foreach($users as $key => $user){
           // if($searchKey == 'user_id') echo 'user[$searchKey] '.$user[$searchKey].' value '.$value." \n"; 
            if($user[$searchKey] === $value){
                $keys[] = $key;
            }
        }
        return $keys;
    }  

    /*public static function getUserIdFromSession($id) {
        $db = Helper::getDb();
        return $db->createCommand('SELECT user_id FROM `session` WHERE `id` = :id')->bindValue(':id', $id)->queryScalar();
    }

    public static function getUserIdFromCookie($val) {
        $identity = unserialize(substr($val,strpos($val, 'a:2:{')));
        if(count(json_decode($identity[1]))){
            $a = json_decode($identity[1]);
            return $a[0];
        }  
    } */  
}