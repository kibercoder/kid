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
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $confirm_password;
    public $first_name;
    public $last_name;
    public $birthdate;
    public $phone;
    public $city;
    public $avatar;
    public $user_avatar;
    public $verifyCode;
    public $role;
    public $confirm = 1;
    public $accept_rules = 0;
    public $party;

    public $startDate; //для валидации даты
    public $endDate; //для валидации даты
    public $startDateTime; //для валидации даты
    public $endDateTime; //для валидации даты
    public $id_avatar_val; //спользуется в шаблоне site/signup

    
    public function init()
    {
        $this->startDate = Yii::$app->params['start_date'];
        $this->endDate = Yii::$app->params['end_date'];

        $this->startDateTime = strtotime($this->startDate);
        $this->endDateTime = strtotime($this->endDate);

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
            [
                ['username', 'first_name', 'last_name', 'city', 'phone', ], 
                'required'
            ],


            /*['confirm', 'required', 'on' => ['register'], 'requiredValue' => 1, 'message' => 'my test message'],*/

            [['confirm', 'accept_rules'], 'boolean'],

            ['confirm', 'compare', 'compareValue' => 1, 
            'message' => 'Подтвердите достоверность данных!'], 
            
            ['accept_rules', 'compare', 'compareValue' => 1, 
                    'message' => 'Вы должны ознакомться с правилами!'
            ],

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

            /*[['birthdate'], 'date', 'format'=>'dd.mm.yyyy', 'message' => 'Неверный формат'],*/

            [
                ['birthdate'], 
                'required',
                'message' => 'Введите дату рождения от 7 до 16 лет'
            ],


            /*[['birthdate'], 'required', 'when' => function ($model) {

                    $choiceDate = strtotime($model->birthdate);
                    $validate = ($this->startDateTime > $choiceDateTime) || ($this->endDateTime < $choiceDate);
                    if ($validate) { 
                        return true; 
                    }
                    return false;
                }, 'whenClient' => "function (attribute, value) {

                startDateValue = '".$this->startDate."';
                startDateValue = startDateValue.split('-');
                startDate = new Date();
                startDate.setFullYear(startDateValue[0],(startDateValue[1] - 1 ),startDateValue[2]);

                endDateValue = '".$this->endDate."';
                endDateValue = endDateValue.split('-');
                endDate = new Date();
                endDate.setFullYear(endDateValue[0],(endDateValue[1] - 1 ),endDateValue[2]);

                choiceDateValue = value.split('.');
                choiceDate = new Date();
                choiceDate.setFullYear(choiceDateValue[2],(choiceDateValue[1] - 1 ),choiceDateValue[0]);

                if ((startDate > choiceDate) || (endDate < choiceDate)) {

                    $('#signupform-birthdate').val('');
     
                    $('.field-signupform-birthdate .help-block-error').text('Только дети от 7 до 18 лет121');

                    console.log('true1');

                    return true;

                } else if ($('#signupform-birthdate').val() == '') {
                    
$('.field-signupform-birthdate .help-block-error').text('Только дети от 7 до 18 лет222');
                    console.log('true2');
                    return true;

                } else {
                    console.log('false');
                    //return false;
                }

               }", 

               'message' => 'Только дети от 7 до 18 лет555',
               'skipOnEmpty'=> false
            ],*/


            ['phone', 'match', 'pattern'=>'/^( +)?((\+?7|8) ?)?((\(\d{3}\))|(\d{3}))?( )?(\d{3}[\- ]?\d{2}[\- ]?\d{2})( +)?$/i'],

            [['user_avatar'], 'integer'],

            [['avatar', 'user_avatar'], 'required', 'when' => function ($model) {
                    $validate = empty($model->avatar) && !is_numeric($model->user_avatar);
                    if ($validate) { 
                        return true; 
                    }
                    return false;
                }, 'whenClient' => "function (attribute, value) {

                id_avatar_val = parseInt($('#signupform-user_avatar').val());

                if (isNaN(id_avatar_val)) {
                    $('#signupform-user_avatar').val('".$this->id_avatar_val."');
                    id_avatar_val = ".$this->id_avatar_val.";
                }

                if($('#signupform-avatar').val() == '' && isNaN(id_avatar_val)){
                $('#choice_avatar .field-signupform-avatar .help-block-error').text('Выберете или загрузите ваш аватар1');
                    return true;
                } else { 

                    $('#choice_avatar .field-signupform-avatar .help-block-error').text('');
                    return false;
                }
               
               }", 'message' => 'Выберете или загрузите ваш аватар2'
            ],

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
                'message' => 'Неверный формат'
            ],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email', 'message' => 'Не верный формат'],
            ['email', 
                'string', 
                'max' => 255,
                'min' => 6,
                'tooShort' => '{attribute} минимум 6 символа', 
                'tooLong' => '{attribute} максимум 255 символов' 
            ],

            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Этот Email адрес уже занят.'],

            
            [['password', 'confirm_password'], 'filter', 'filter' => 'trim'],

            [['password', 'confirm_password'], 'required'],

            [
                ['password', 'confirm_password'], 
                'string', 
                'min' => 6,
                'tooShort' => '{attribute} минимум 6 символа'
            ],

            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароль отличается от этого поля!'],

            //['verifyCode', 'captcha','captchaAction'=>'user/captcha']

            ['verifyCode', 'captcha'],

            ['party','in','range'=>['red','green','blue'],'strict'=>true],

            ['role','in','range'=>['user','moder','admin'],'strict'=>true],
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
            'birthdate' => 'Дата',
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
    public function signup()
    {

        $this->role = 'user';
        $this->party = 'red';


        if (!$this->validate()) {
            //var_dump($this->getErrors());
            return null;
        }

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


        if ($avatar['success']) {
            $this->avatar = $avatar['namefile'];
        } else {

            $id_user_avatar = (int)$this->user_avatar;

            $model_avatar = new Avatar();

            $sql_avatar =  $model_avatar::find()
                            ->where(['id_avatar' => $id_user_avatar])
                            ->select(['*'])->asArray()->one();

            //Если нету такого аватара в базе то null
            if(!is_numeric($sql_avatar['id_avatar'])) {
                return null;
            }

            $this->avatar = '';
        }

        $user = new User();

        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->birthdate = strtotime($this->birthdate);
        $user->city = $this->city;
        $user->phone = $this->phone;
        $user->avatar = $this->avatar;

        $user->username = $this->username;
        $user->email = $this->email;

        $user->setPassword($this->password);
        $user->generateAuthKey();

        if ($id_user_avatar) {

            if ($user->save()) {

                $modelUserAvatar = new UserAvatar();
                $modelUserAvatar->id_a = $id_user_avatar;
                $modelUserAvatar->id_u = $user->id;

                if ($modelUserAvatar->save()) {
                    return $user;
                } else {
                    $user->delete();
                    return null;
                }

            }

        } else {

            return $user->save() ? $user : null;
        }
    }
}
