<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\web\UploadedFile;
use common\helpers\CheckUploadFile;
use common\helpers\Translit;
use common\models\Avatar;
use common\models\UserAvatar;


/**
 * Profile form
 */
class ProfileForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $confirm_password;
    public $first_name;
    public $last_name;
    public $phone;
    public $city;
    public $avatar;
    public $user_avatar;

    public $id_avatar_val; //спользуется в шаблоне site/signup

    
    public function init()
    {
        
        $model_avatar = new Avatar();

        $men_avatars =  $model_avatar::find()
                        ->where(['gender' => 'm'])
                        ->select(['*'])->asArray()->one();

        $this->id_avatar_val = $men_avatars['id_avatar'];

    }


    public function rules()
    {

        return [
            [
                ['username', 'first_name', 'last_name', 'city', 'phone',], 
                'trim'
            ],
            /*[
                ['username', 'first_name', 'last_name', 'city', 'phone', ], 
                'required'
            ],*/

            [
                ['first_name', 'last_name'], 
                'string', 
                'min' => 2, 
                'max' => 100,
                'tooShort' => '{attribute} минимум 2 символа', 
                'tooLong' => '{attribute} максимум 100 символов' 
            ],

            [
                'city', 
                'string', 
                'min' => 2, 
                'max' => 120,
                'tooShort' => '{attribute} минимум 2 символа', 
                'tooLong' => '{attribute} максимум 120 символов' 
            ],

            [
                ['first_name', 'last_name'],
                'match', 
                'pattern'=>'/^[а-яА-Я]{2,50}$/iu', 
                'message' => 'Неверный формат'
            ],

            [
                ['city'],
                'match',
                'pattern'=>'/^[а-яА-Я0-9]{2,50}$/iu',
                'message' => 'Неверный формат'
            ],

            ['phone', 'match', 'pattern'=>'/^( +)?((\+?7|8) ?)?((\(\d{3}\))|(\d{3}))?( )?(\d{3}[\- ]?\d{2}[\- ]?\d{2})( +)?$/i'],

            [
                ['user_avatar'], 'integer',
                'skipOnEmpty' => true
            ],

            /* [['avatar', 'user_avatar'], 'required', 'when' => function ($model) {              
                    $validate = empty($model->avatar) && !is_numeric($model->user_avatar);
                    if ($validate) { 
                        return true; 
                    }
                    return false;
                },'whenClient' => "function (attribute, value) {

                id_avatar_val = parseInt($('#profileform-user_avatar').val());

                if (isNaN(id_avatar_val)) {
                    $('#profileform-user_avatar').val('".$this->id_avatar_val."');
                    id_avatar_val = ".$this->id_avatar_val.";
                }

                if($('#profileform-avatar').val() == '' && isNaN(id_avatar_val)){
                $('#choice_avatar .field-profileform-avatar .help-block-error').text('Выберете или загрузите ваш аватар1');
                    return true;
                } else { 

                    $('#choice_avatar .field-profileform-avatar .help-block-error').text('');
                    return false;
                }
               
               }", 'message' => 'Выберете или загрузите ваш аватар2'
               
             ],*/

            [
                ['avatar'], 'file', 
                'extensions' => 'jpg, png, gif, jpeg', 
                'wrongExtension' => 'Только jpg, png, gif',
                'maxSize' => Yii::$app->params['max_filesize_img'],
                'minSize' => 205 * 205,
                'tooBig' => 'Максимальный файл 10мб',
                'tooSmall' => 'Минимальный файл - 205x205px', 
                'skipOnEmpty' => true
            ],
/*
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Пользователь уже существует.'],

            [
                'username', 
                'string', 
                'min' => 2, 
                'max' => 50,
                'tooShort' => '{attribute} минимум 2 символа', 
                'tooLong' => '{attribute} максимум 50 символов' 
            ],

            [
                'username', 
                'match', 
                'pattern'=>'/^[а-яА-Я0-9-_]+$/iu', 
                'message' => 'Неверный формат (Допускаются только цифры и буквы русского алфавита)'
            ],
            */
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email', 'message' => 'Не верный формат'],
            ['email', 
                'string', 
                'max' => 255,
                'min' => 6,
                'tooShort' => '{attribute} минимум 6 символа', 
                'tooLong' => '{attribute} максимум 255 символов',
                'skipOnEmpty' => true 
            ],

            ['email', 'unique' , 'when' => function ($model) { 
                $user = User::findOne(\Yii::$app->user->identity->id);                     
                return ($model->email != $user->email);
            },'targetClass' => '\common\models\User', 'message' => 'Этот Email адрес уже занят.'],

            //[['email'], 'common\components\validators\EmailUserValidator'],

            [['password', 'confirm_password'], 'filter', 'filter' => 'trim'],

            [
                ['password', 'confirm_password'], 
                'string', 
                'min' => 6,
                'tooShort' => '{attribute} минимум 6 символа'
            ],

            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароль отличается от этого поля!'],
        ];
    }
    

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'username' => 'Ник', 
            'first_name' => 'Имя', 
            'last_name' => 'Фамилия',
            'city' => 'Город',
            'phone' => 'Номер',
            'email' => 'Mail',
            'avatar' => 'Фото',
            'password' => 'Пароль',
            'confirm_password' => 'Повтор пароля'

        ];
    }


    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function saveProfile($data)
    {
        if (!$this->validate()) {
            //var_dump($this->getErrors());
            return null;
        }

        $user = User::findOne(\Yii::$app->user->identity->id);
        
        $uploadFile = new CheckUploadFile();

        $this->avatar = UploadedFile::getInstance($this, 'avatar');

        $file_name = Translit::RusTranslit($this->username);

        $avatar = $uploadFile->checkImage(
            Yii::$app->params['max_filesize_img'], 
            Yii::$app->params['fullPathAvatar'].'new/',
            165,
            165,
            $this->avatar,
            ['jpg','jpeg','gif','png'],
            $file_name
        );

        $id_user_avatar = false;

//echo '<pre>'.print_r($avatar, true).'</pre>';
        if ($avatar['success']) {
            $user->avatar = $avatar['namefile'];           
        } else if((int)$this->user_avatar){

            $id_user_avatar = (int)$this->user_avatar;

            $model_avatar = new Avatar();

            $sql_avatar =  $model_avatar::find()
                            ->where(['id_avatar' => $id_user_avatar])
                            ->select(['*'])->asArray()->one();

            //Если нету такого аватара в базе то null
            if(!is_numeric($sql_avatar['id_avatar'])) {
                return null;
            }

            unlink(Yii::$app->params['fullPathAvatar'].'new/'.$user->avatar);
            $user->avatar = '';
        }
 //  echo '<pre>'.print_r($user, true).'</pre>';die();

     
        if($this->first_name){
            $user->first_name = $this->first_name;
        }
        if($this->last_name){
            $user->last_name = $this->last_name;
        }
        if($this->city){
            $user->city = $this->city;
        }
        if($this->phone){
            $user->phone = $this->phone;
        }
        /*if($this->avatar){
            $user->avatar = $this->avatar;
        }*/
        if($this->username){
            $user->username = $this->username;
        }
        if($this->email){
            $user->email = $this->email;
        }
        if($this->password){
            $user->setPassword($this->password);
        }

        if ($id_user_avatar) {

            if ($user->save()) {
                //проверяем на то что запись в таблице UserAvatar уже сушествует т если ее нет то создаем новоую
                $modelUserAvatar = UserAvatar::findOne(['id_u' => $user->id]);
                if(!$modelUserAvatar){
                    $modelUserAvatar = new UserAvatar();
                }
                $modelUserAvatar->id_a = $id_user_avatar;
                $modelUserAvatar->id_u = $user->id;
                if ($modelUserAvatar->save()) {
                    return $user;
                }
            }
        } else {
            //если не передан id_user_avatar то чистим таблицу UserAvatar
            $modelUserAvatar = UserAvatar::findOne(['id_u' => $user->id]);
            if( $modelUserAvatar){
                $modelUserAvatar->delete();
            }
            return $user->save() ? $user : null;
        }
    }
}
