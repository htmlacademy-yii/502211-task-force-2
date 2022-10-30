<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tasks;

/**
 * @property array $categories;
 */
class SearchTasks extends Tasks
{
    public $categories = [];
    public $timePeriod = 0;
    public $without_customer;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['timePeriod'], 'integer'],
            [['without_customer'], 'string'],
            [['categories'], 'filter', 'filter' => 'array_filter'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        
        $this->load($params);

        $query->where(['status' => 'new'])->orderBy('dt_add DESC');

        $query->andFilterWhere(['category_id' => $this->categories]);

        if ($this->without_customer === '1') {
            $query->where(['customer_id' => null]);
        }

        if ($this->timePeriod !== 0) {
            $query->andWhere((['<', 'dt_add', time() - $this->timePeriod]));
        }

        return $dataProvider;
    }
}
