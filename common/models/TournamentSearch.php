<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Tournament;

/**
 * TournamentSearch represents the model behind the search form of `common\models\Tournament`.
 */
class TournamentSearch extends Tournament
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_t', 'fund', 'date_begin', 'max_member'], 'integer'],
            [['title', 'photo', 'type', 'type_age'], 'safe'],
            [['cost', 'first_place', 'second_place', 'third_place'], 'number'],
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
        $query = Tournament::find();

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
            'id_t' => $this->id_t,
            'cost' => $this->cost,
            'fund' => $this->fund,
            'first_place' => $this->first_place,
            'second_place' => $this->second_place,
            'third_place' => $this->third_place,
            'date_begin' => $this->date_begin,
            'max_member' => $this->max_member,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'type_age', $this->type_age]);

        return $dataProvider;
    }
}
