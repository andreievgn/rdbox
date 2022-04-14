<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Order;

/**
 * OrderhClient represents the model behind the search form of `backend\models\Order`.
 */
class SearchOrder extends Order
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'visit', 'created_at'], 'integer'],
            [['price', 'discount_price', 'url_qrcode', 'url_activate'], 'safe'],
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
        $query = Order::find();

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
            'visit' => $this->visit,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'discount_price', $this->discount_price])
            ->andFilterWhere(['like', 'url_qrcode', $this->url_qrcode]);

        return $dataProvider;
    }
}
