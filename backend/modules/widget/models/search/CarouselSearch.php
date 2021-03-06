<?php

namespace backend\modules\widget\models\search;

use core\models\WidgetCarousel;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * WidgetCarouselSearch represents the model behind the search form about `core\models\WidgetCarousel`.
 */
class CarouselSearch extends WidgetCarousel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['key'], 'safe'],
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
     * @param mixed $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = WidgetCarousel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id'     => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'key', $this->key]);

        return $dataProvider;
    }
}
