<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\acms\models;

use app\models\PostEventsTemplates;

/**
 * класс поиска шаблонов
 *
 * @author igorb
 */
class PostEventsTemplatesSearch extends PostEventsTemplates {
    public $subject = null;
    public $from_name = null;
    
    public function rules()
    {
        return [
            [['is_active', 'delay'], 'integer'],           
            [['content_type'], 'string'],
            [['type_event'], 'string', 'max' => 31],            
            [['from_email', 'subject', 'from_name'], 'string'],
        ];
    }

    public function search($params)
    {
        $languageCode = \Yii::$app->translate->getLanguageCode();
        
        $query = PostEventsTemplates::find();
        
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query'	=> $query,
            'sort' => ['defaultOrder' => ['id'=>SORT_DESC]],
        ]);

        $query->join('INNER JOIN', 'post_events_templates_languages', 
            'post_events_templates_languages.template_id = post_events_templates.id');
        
        $this->load($params);
        
        if (!$this->validate()) {
            return $dataProvider;
        }
        
        //поиск по типу события
        if(!empty($this->type_event)) {
            $keys = \app\models\PostEvents::getTypeEventsByLikeTranslateName($this->type_event);
        
            if(is_array($keys) && count($keys) > 0) {//ищем по ключам
                $query->andFilterWhere([
                    'type_event' => $keys,
                ]);
            }
            else {//нельзя находить что-нибудь если ключей не найдено
                $query->andFilterWhere([
                    'id' => '0',
                ]);
            }
        }
        
        //поиск по e-mail отправителя        
        if(!empty($this->from_email)) {
            $query->andFilterWhere(['like', 'from_email', $this->from_email]);
            
            /**
            * + ищем с стандартных настройках писем
            * этот e-mail, если он есть,
            * то добавим в список щаблоны, у которых 
            * нет e-mail, а значит задан по умолчанию
            */
           $modelSettings = \app\models\PostEventsSettings::find()
                   ->filterWhere(['like', 'from_email', $this->from_email])
                   ->one();
           
           if($modelSettings) {               
               $query->orWhere('(from_email IS NULL OR from_email = "")');               
           }
        }        
        
        //поиск по теме
        if(!empty($this->subject)) {
            
            $query->andFilterWhere(['like', 'subject', $this->subject]);
        }
        
        //поиск по имени отправителя
        if(!empty($this->from_name)) {
            //проверим имя отправителя в общих настройках
           $modelSettings = \app\models\PostEventsSettings::find()
                   ->filterWhere(['like', 'from_name', $this->from_name])
                   ->one();
           
           if($modelSettings) {               
               $query->andWhere(
                    '   post_events_templates_languages.from_name IS NULL
                    OR
                        post_events_templates_languages.from_name = ""
                    OR 
                        post_events_templates_languages.from_name LIKE :from_name
                ', [
                    ':from_name' => "%$this->from_name%",
                ]);
           }
           else {
               //проверим имя отправителя в языковых настройках шаблона            
                $query->andFilterWhere(['like',
                    'post_events_templates_languages.from_name', $this->from_name]);
           }
        }
        
        //поиск по типу контента
        $query->andFilterWhere([
            'content_type' => $this->content_type,
        ]);
        
        //поиск по активности
        $query->andFilterWhere([
            'is_active' => $this->is_active,
        ]);
        
        //поиск по мгновенной отправке
        $query->andFilterWhere([
            'delay' => $this->delay,
        ]);
        
        return $dataProvider;
    }
}
