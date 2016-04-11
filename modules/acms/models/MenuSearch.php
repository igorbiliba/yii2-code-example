<?php

namespace app\modules\acms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Menu;

/**
 * MenuSearch represents the model behind the search form about `app\models\Menu`.
 */
class MenuSearch extends Menu
{
    public $name = null;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_active'], 'integer'],
            [['type', 'created_at', 'updated_at'], 'safe'],
            [['name'], 'string'],
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
        $query = Menu::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'is_active' => $this->is_active,
        ]);

        /**
         * нужно искать по переводам
         */
        if(!empty($this->name)) {
            $query->join('INNER JOIN', 'menu_language', 'menu_language.menu_id = menu.id');
            $query->andFilterWhere([
                'like', 'menu_language.name', $this->name
            ]);
        }
        
        //$query->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
