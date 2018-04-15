<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;
use common\models\Session;
use common\models\UserAvatar;
use common\models\Avatar;
use common\helpers\Translit;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const ROLE_USER = 'user';
    const ROLE_MODER = 'moder';
    const ROLE_ADMIN = 'admin';

    //эти переменные нужны для авторизации через E сети
    public $profile;
    public $authKey;
    public $confirm_password;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }


    //Метод для вывода аватарки в комментариях
    public static function getAvatar($id_user)
    {

        $user = static::findOne(['id' => $id_user, 'status' => self::STATUS_ACTIVE]);

        $file_avatar = Yii::$app->basePath.'/web/avatars/165x165/new/'.$user->avatar;

        if (file_exists($file_avatar) 
            && preg_match('/\.(?:jp(?:e?g|e|2)|gif|png)$/i', $user->avatar)) {
            $avatar = '/avatars/165x165/new/'.$user->avatar;
        } else {
            $get_id_a = UserAvatar::find()
                        ->where(['id_u' => $id_user])
                        ->select(['id_a'])->asArray()->one();

            $get_ava = Avatar::find()
                        ->where(['id_avatar' => $get_id_a['id_a']])
                        ->select(['avatar_name'])->one();

            $file_avatar = Yii::$app->basePath.'/web/avatars/165x165/site/'.$get_ava->avatar_name;

            if (file_exists($file_avatar) 
            && preg_match('/\.(?:jp(?:e?g|e|2)|gif|png)$/i', $get_ava->avatar_name)) {
                $avatar = '/avatars/165x165/site/'.$get_ava->avatar_name;
            } else {

                $model_avatar = new Avatar();
                $men_avatars =  $model_avatar::find()
                                ->where(['gender' => 'm'])
                                ->select(['avatar_name'])->one();

                $avatar = '/avatars/165x165/site/'.$men_avatars->avatar_name;

            }

        }

        return $avatar;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
     
        if (Yii::$app->getSession()->has('user-'.$id)) {
            return Yii::$app->getSession()->get('user-'.$id);
        }
        else {
             return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
        }
    }

    /**
     * @param \nodge\eauth\ServiceBase $service
     * @return User
     * @throws ErrorException
     */
    /*public static function findByEAuth($service) {
        if (!$service->getIsAuthenticated()) {
            throw new ErrorException('EAuth user should be authenticated before creating identity.');
        }

        $id = $service->getServiceName().'-'.$service->getId();
        $attributes = [
            'id' => $id,
            'username' => $service->getAttribute('name'),
            'authKey' => md5($id),
            'profile' => $service->getAttributes(),
            'first_name' => $service->getAttribute('first_name'),
        ];
        $attributes['profile']['service'] = $service->getServiceName();

        Yii::$app->getSession()->set('user-'.$id, $attributes);
        return new self($attributes);
    }*/

    public static function findByEAuth($service) {
        if (!$service->getIsAuthenticated()) {
            throw new ErrorException('EAuth user should be authenticated before creating identity.');
        }

        $model = self::getUserByService($service);

        return $model;

        $model->profile=$service->getAttributes();

        Yii::$app->getSession()->set('user-'.$model->id, $model);

        return $model;
    }



    public static function getUserByService($service)
    {
        //пытаемся найти нашего пользователя        
        $model = User::find()->where(
                [
                    'service' => $service->getServiceName(),
                    'social_id' => $service->getId()
                ]
        )->one();

        if (!$model)
        {
           // если не нашли то создаем нового 
           $model = new User();
           // создаем уникальное имя пользователя 
           $model->username = $service->getAttribute('name');
            // генерируем пароль 
           $model->password_hash = Yii::$app->security->generatePasswordHash(Yii::$app->security->generateRandomString());
           $model->auth_key = Yii::$app->security->generateRandomString();
           $model->service = $service->getServiceName();
           $model->social_id = $service->getId();
           $model->display_name = $service->getServiceName().'-'.$service->getId();
           $model->birthdate = $service->getAttribute('birthdate');
           $model->city = $service->getAttribute('city');

           $model->first_name = $service->getAttribute('first_name');
           $model->last_name = $service->getAttribute('last_name');

           $model->service_url = $service->getAttribute('url');

           $model->role = 'user';

        }

        return $model;

        $model->avatar = '';

        $src_ava = $service->getAttribute('avatar','');

        $ext_ava = preg_replace("/.*?\./", '', $src_ava);

        // Validate the file type // File extensions
        $fileTypes = array('jpg','jpeg','gif','png');

        if (in_array(strtolower($ext_ava), $fileTypes)) {

            $targetPath = Yii::$app->basePath.'/web/avatars/tmp/';

            $file_name = Translit::RusTranslit($model->username);

            $targetFile = $targetPath.$file_name.'.'.$ext_ava;

            $get_ava = file_get_contents($src_ava);

            if ($get_ava && strlen($get_ava) <= Yii::$app->params['max_filesize_img']) {

                if (file_put_contents($targetFile, $get_ava)){
                    $model->avatar = $file_name.'.'.$ext_ava;
                }

            }

        }



        //если вы хотите сохранить пользователя то вените вот это
        return $model->save() ? $model : null;

    }


    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function getPassword()
    {
        return '';
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Check user online
     */
    public static function checkUserOnline($user_id)
    {
        $sql = 'SELECT user_id FROM session WHERE last_write - 3600 < NOW() AND user_id = '.$user_id;
        if(Yii::$app->db->createCommand($sql)->execute()){
            return true;
        }else{
            return false;
        }
    }  
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOnline()
    {
        return $this->hasOne(Session::className(), ['user_id' => 'id'])->andWhere(['<', '(last_write - 3600)', new Expression('NOW()')]);
    } 

}
