<?php

namespace mirocow\seo\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use mirocow\seo\models\Meta;

/**
 * MetaSearch represents the model behind the search form of `mirocow\seo\models\Meta`.
 */
class MetaSearch extends Meta
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key', 'name', 'content', 'lang'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Meta::find();

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
        $query->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'lang', $this->lang]);

        return $dataProvider;
    }
}
