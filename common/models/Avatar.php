<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "avatar".
 *
 * @property int $id_avatar
 * @property string $avatar_name
 * @property string $gender
 *
 * @property UserAvatar[] $userAvatars
 * @property User[] $us
 */
class Avatar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'avatar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gender'], 'required'],
            [['gender'], 'string'],
            ['gender', 'in', 'range' => ['m', 'w'], 'strict' => false],

            [['avatar_name'], 'required', 'when' => function($model) {
                return $model->avatar_name == '';
            },'whenClient' => "function (attribute, value) {
                return $('input#avatar-avatar_name').attr('value') == undefined;
            }"],
            
            [
                ['avatar_name'], 'file', 
                'extensions' => 'jpg, png, gif, jpeg', 
                'wrongExtension' => 'Только jpg, png, gif',
                'maxSize' => Yii::$app->params['max_filesize_img'],
                'minSize' => 205 * 205,
                'tooBig' => 'Максимальный файл 10мб',
                'tooSmall' => 'Минимальный файл - 205x205px', 
                'skipOnEmpty' => true
            ],


        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_avatar' => 'Id',
            'avatar_name' => 'Картинка',
            'gender' => 'Мужчина или женщина?',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAvatars()
    {
        return $this->hasMany(UserAvatar::className(), ['id_a' => 'id_avatar']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUs()
    {
        return $this->hasMany(User::className(), ['id' => 'id_u'])->viaTable('userAvatar', ['id_a' => 'id_avatar']);
    }
}
