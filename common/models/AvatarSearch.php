<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Avatar;

/**
 * AvatarSearch represents the model behind the search form of `common\models\Avatar`.
 */
class AvatarSearch extends Avatar
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_avatar'], 'integer'],
            [['avatar_name', 'gender'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Avatar::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_avatar' => $this->id_avatar,
        ]);

        $query->andFilterWhere(['like', 'avatar_name', $this->avatar_name])
            ->andFilterWhere(['like', 'gender', $this->gender]);

        return $dataProvider;
    }
}
