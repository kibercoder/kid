<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "timeout".
 *
 * @property int $id
 * @property string $name
 * @property int $easy
 * @property int $middle
 * @property int $hard
 * @property int $nightmare
 */
class Timeout extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'timeout';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'easy', 'middle', 'hard', 'nightmare'], 'required'],
            [['easy', 'middle', 'hard', 'nightmare'], 'integer'],
            [['name'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'easy' => 'Easy',
            'middle' => 'Middle',
            'hard' => 'Hard',
            'nightmare' => 'Nightmare',
        ];
    }
}
