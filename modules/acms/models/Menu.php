<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\acms\models;

/**
 * Description of Menu
 *
 * @author igorb
 */
class Menu extends \app\models\Menu {
    public $name = null;
    
    public function afterFind() {
        parent::afterFind();
        
        if(empty($this->name)) {
            $this->name = $this->getName();
        }
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return \yii\helpers\ArrayHelper::merge(parent::rules(), [
            [['name'], 'required'],
        ]);
    }
    
    /**
     * вернет все переводы по активным языкам.
     * недостающие создаст
     */
    public function getTranslates($andDefault = true) {        
        //все переводы
        $allTranslate = $this->getMenuLanguages()->all();
        
        //все языки доступные
        $languagesModels = \app\modules\acms\models\Languages::find()
                ->active()
                ->all();
        
        //ищем недостающий перевод
        foreach ($languagesModels as $model) {
            /* @var $model \app\models\Languages */            
            
            $translate = null;
            foreach ($allTranslate as $itemTranslate) {
                /* @var $itemTranslate \app\models\MenuLanguage */
                if($itemTranslate->language_id == $model->id) {
                    $translate = $itemTranslate;
                }
            }
            
            //значит создаем перевод и добаляем в список
            if(!$translate && ($this->id > 0)) {
                $translate = new \app\models\MenuLanguage;
                $translate->menu_id = $this->id;
                $translate->language_id = $model->id;                
                $allTranslate[] = $translate;
            }
        }
        
        /**
         * уберем язык по умолчанию и скоупа
         */
        if(!$andDefault) {
            $default = Languages::getDefaultLanguage();
            foreach ($allTranslate as $key => $item) {
                if($item->language_id == $default->id) {
                    unset($allTranslate[$key]);
                }
            }
        }
        
        return $allTranslate;
    }
    
    /**
     * сохраним меню с мультиязычным названием
     * 
     * @return boolean
     */
    public function save($runValidation = true, $attributeNames = null) {
        if(parent::save()) {            
            //запишем перевод по умолчанию
            $lang = Languages::getDefaultLanguage();
            
            if($lang) {
                //сначала поищем перевод для этого меню
                $translate = $this->getMenuLanguages()
                        ->where([
                            'menu_language.language_id' => $lang->id,
                        ])->one();
                
                if($translate) {                    
                    $translate->name = $this->name;
                    $translate->save();
                }
                else {                    
                    $translate = new \app\models\MenuLanguage();
                    $translate->menu_id = $this->id;
                    $translate->language_id = $lang->id;
                    $translate->name = $this->name;
                    $translate->save();
                }
            }
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Вернет все меню
     */
    public static function getAll() {
        $list = [
            null => ''
        ];
        
        foreach (self::find()->all() as $value) {
            $list[$value->id] = $value->name;
        }
        
        return $list;
    }
}