<?php

namespace app\modules\acms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\acms\models\TextBlock;

/**
 * TextBlockSearch represents the model behind the search form about `app\models\TextBlock`.
 */
class TextBlockSearch extends TextBlock
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active'], 'integer'],
            [['title'], 'string', 'max' => 127],
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
        $query = TextBlock::find();

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
            'id' => $this->id,
            'is_active' => $this->is_active,
            'is_use_editor' => $this->is_use_editor,
        ]);

        if(!empty($this->title)) {
            $query->join('INNER JOIN', 'text_block_languages', 'text_block.id = text_block_languages.text_block_id');
            $query->andFilterWhere([
                'like', 'title', $this->title
            ]);
        }
        
        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'js', $this->js]);

        return $dataProvider;
    }
}
