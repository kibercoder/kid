<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "map".
 *
 * @property int $id_map
 * @property string $country Название страны
 * @property string $country_en Английское название
 * @property string $short_name Короткое название
 * @property string $coordinates Координаты
 * @property string $fill_color Цвет
 *
 * @property QuestionAnswerMap[] $questionAnswerMaps
 * @property TournamentQuestion[] $ids
 */
class Map extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'map';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_en', 'short_name', 'coordinates'], 'required'],
            [['country'], 'required', 'message' => ''],

            [['coordinates'], 'string'],
            [['country'], 'string', 'max' => 255],
            [['country_en'], 'string', 'max' => 100],
            [['short_name', 'fill_color'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_map' => 'Id Map',
            'country' => 'Название страны',
            'country_en' => 'Английское название',
            'short_name' => 'Короткое название',
            'coordinates' => 'Координаты',
            'fill_color' => 'Цвет',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionAnswerMaps()
    {
        return $this->hasMany(QuestionAnswerMap::className(), ['id_map' => 'id_map']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIds()
    {
        return $this->hasMany(TournamentQuestion::className(), ['id' => 'id'])->viaTable('questionAnswerMap', ['id_map' => 'id_map']);
    }
}
