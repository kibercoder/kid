<?php

namespace frontend\models;
use Yii;
use common\models\User;
use frontend\models\Timeout;


/**
 * This is the model class for table "game".
 *
 * @property int $id
 * @property int $user_id идентификатор пользователя
 * @property string $name название игры
 * @property string $action событие игры
 * @property string $complexity сложность
 * @property string $hash хеш страницы игры
 * @property int $created метка времни
 */
class Game extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'game';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'action', 'complexity', 'hash', 'created'], 'required'],
            [['user_id', 'created'], 'integer'],
            [['action', 'complexity'], 'string'],
            [['name', 'hash'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'идентификатор пользователя',
            'name' => 'название игры',
            'action' => 'событие игры',
            'complexity' => 'сложность',
            'hash' => 'хеш страницы игры',
            'created' => 'метка времени',
        ];
    }

     /**
     * getLastGameStart
     * Проверка того что игра не была начата ранее
     *
     * @return obj Game if exist 
     */
    public function getLastGameStart(){
        return Game::find()->where([
            'user_id' => \Yii::$app->user->identity->id,
        ])->orderBy([
            'created' => SORT_DESC
        ])->one();
    }   

      /**
     * checkGameStart
     * Проверка того что игра не была начата ранее
     *
     * @return bool 
     * true означет что игра не была начата и можно запускать новую игру
     * false означает что ранее начатая игра не была еще закончена и нельзя запускать новую
     */
    public function checkGameStart(){
        //Добавить проверку на выбор цели и на то что б пользователь досмотрел ролик в академии до конца
        $lastGame = $this->getLastGameStart();
        if(!$lastGame || $lastGame->action == 'exit' || $lastGame->action == 'end' ){
            return  true;
        } 
        //проверка на то что игра была начата ранее  
        if($lastGame->action = 'start') {
            $timeOut = Timeout::find()->where([
                'name'  => $lastGame->name
    
            ])->one();
            $timeOutSec = $timeOut->{$lastGame->complexity} * 60;
            return (time() > ($timeOutSec + $lastGame->created)) ? true : false ;
        }
    } 
    

       /**
     * checkStartGameEarly
     * Проверка того что игра была начата ранее
     *
     * @return bool 
     * true означет что игра была начата
     * false означает что игра не была начатая игра или была начата когда то давно
     */
    public function checkStartGameEarly($hash){
        //Добавить проверку на выбор цели и на то что б пользователь досмотрел ролик в академии до конца
        $lastGame = $this->getLastGameStart();
        if(!$lastGame || $lastGame->action == 'exit' || $lastGame->action == 'end' ){
            return  false;
        }  
        if($lastGame->action == 'start' && $hash == $lastGame->hash) {
            return  true;
        }
    }   
 
    /**
     * checkBlockEasy
     * Проверка на блок легког уровня
     *
     * @return bool 
     * true  нужно заблокировать
     * false не  нужно заблокировать
     */
    public function checkBlockEasy($name){
        $count = Game::find()->where([
            'user_id' => ($id) ? $id : \Yii::$app->user->identity->id,
            'complexity' => 'easy',
            'action' => 'end',
            'name'  => $name

        ])->count();
        return ($count > 10) ? true : false;
    }   
}
