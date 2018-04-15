<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Comment;

/**
 * CommentSearch represents the model behind the search form of `common\models\Comment`.
 */
class CommentSearch extends Comment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'entityId', 'parentId', 'level', 'createdBy', 'updatedBy', 'status', 'createdAt', 'updatedAt', 'count_like'], 'integer'],
            [['entity', 'content', 'relatedTo', 'url'], 'safe'],
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
        $query = Comment::find();

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
            'id' => $this->id,
            'entityId' => $this->entityId,
            'parentId' => $this->parentId,
            'level' => $this->level,
            'createdBy' => $this->createdBy,
            'updatedBy' => $this->updatedBy,
            'status' => $this->status,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'count_like' => $this->count_like,
        ]);

        $query->andFilterWhere(['like', 'entity', $this->entity])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'relatedTo', $this->relatedTo])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
