<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-menu
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-menu
 * @version 0.9.3
 */

namespace cinghie\menu\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ItemsSearch represents the model behind the search form about `cinghie\menu\models\Items`.
 */
class ItemsSearch extends Items
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'menutype_id', 'parent_id', 'state'], 'integer'],
            [['title', 'alias', 'link', 'class', 'linkOptions', 'params','access', 'language'], 'safe'],
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
        $query = Items::find()->where('id != :id', [ 'id' => 1 ]);

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
            'menutype_id' => $this->menutype_id,
            'parent_id' => $this->parent_id,
            'state' => $this->state,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'class', $this->class])
            ->andFilterWhere(['like', 'linkOptions', $this->linkOptions])
            ->andFilterWhere(['like', 'params', $this->params])
            ->andFilterWhere(['like', 'access', $this->access])
            ->andFilterWhere(['like', 'language', $this->language]);

        return $dataProvider;
    }
}
