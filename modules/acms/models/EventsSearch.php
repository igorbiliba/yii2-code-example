<?php

namespace app\modules\acms\models;

use \app\models\PostEvents;
use \yii\data\ActiveDataProvider;

/**
 * поиск для писем в стеке
 */
class EventsSearch extends PostEvents {
    public static function getListStatus() {
        return [
            self::STATUS_WAIT => \Yii::$app->translate->get('wait'),
            self::STATUS_IS_SEND => \Yii::$app->translate->get('is_send'),
            self::STATUS_TROUBLE => \Yii::$app->translate->get('trouble'),
        ];
    }

    public function rules()
    {
        return [
            [['subject', 'status'], 'string'],
        ];
    }
    
    public function search($params)
    {
        $query = PostEvents::find();
        
        $dataProvider = new ActiveDataProvider([
            'query'	=> $query->notCopy(),
            'sort' => ['defaultOrder' => ['id'=>SORT_DESC]],
        ]);

        $this->load($params);
        
        if (!$this->validate()) {
            return $dataProvider;
        }
        
        $query->andFilterWhere(['like', 'subject', $this->subject]);
        
        $query->andFilterWhere([
            'status' => $this->status,
        ]);
        
        return $dataProvider;
    }
}
