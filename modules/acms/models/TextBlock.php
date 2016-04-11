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
class TextBlock extends \app\models\TextBlock {
    //поля мультиязычности
    public $title = null;
    public $text = null;    
    public $clear;
    //*********************

    /**
     * ид изображений для адаптивности
     *
     * @var type 
     */
    public static $CurrentSizeId = 'TEXT_BLOCK';
    
    /**
     * @var UploadedFile
     */
    public $imageFile;
    
    public function afterFind() {
        parent::afterFind();
        
        if(empty($this->name)) {
            $this->title = $this->getTitle();
            $this->text = $this->getText();
        }
    }

    public function attributeLabels() {
        return \yii\helpers\ArrayHelper::merge(parent::attributeLabels(), [            
            'text' => \Yii::$app->translate->get('content'),
        ]);        
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return \yii\helpers\ArrayHelper::merge(parent::rules(), [
            [['title', 'text'], 'required'],
            [['clear'], 'integer'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ]);
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $dir = \Yii::$app->basePath . '/web/images/content_blocks/origin';
            if(!is_dir($dir)) {
                mkdir($dir);
            }
            $this->image = $dir . '/' . md5($this->id . '_'. rand(9999999, 99999999).'_'.time()) . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($this->image);
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * вернет все переводы по активным языкам.
     * недостающие создаст
     */
    public function getTranslates($andDefault = true) {        
        //все переводы
        $allTranslate = $this->getTextBlockLanguages()->all();
        
        //все языки доступные
        $languagesModels = \app\modules\acms\models\Languages::find()
                ->active()
                ->all();
        
        //ищем недостающий перевод
        foreach ($languagesModels as $model) {
            /* @var $model \app\models\Languages */            
            
            $translate = null;
            foreach ($allTranslate as $itemTranslate) {
                /* @var $itemTranslate \app\models\TextBlockLanguages */
                if($itemTranslate->language_id == $model->id) {
                    $translate = $itemTranslate;
                }
            }
            
            //значит создаем перевод и добаляем в список
            if(!$translate && ($this->id > 0)) {                
                $translate = new \app\models\TextBlockLanguages;
                $translate->text_block_id = $this->id;
                $translate->language_id = $model->id;
                $translate->save();
                $allTranslate[] = $translate;
            }
        }
        
        /**
         * уберем язык по умолчанию из скоупа
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
     * сохраним с мультиязычным названием
     * 
     * @return boolean
     */
    public function save($runValidation = true, $attributeNames = null) {
        if(parent::save()) {            
            //запишем перевод по умолчанию
            $lang = Languages::getDefaultLanguage();
            
            if($lang) {
                //сначала поищем перевод
                $translate = $this->getTextBlockLanguages()
                        ->where([
                            'text_block_languages.language_id' => $lang->id,
                        ])->one();
                
                if($translate) {                    
                    $translate->text = $this->text;
                    $translate->title = $this->title;
                    $translate->save();
                }
                else {                    
                    $translate = new \app\models\TextBlockLanguages();
                    $translate->text_block_id = $this->id;
                    $translate->language_id = $lang->id;
                    $translate->text = $this->text;
                    $translate->title = $this->title;
                    $translate->save();
                }
            }
            
            return true;
        }
        
        return false;
    }
    
    /**
     * вернет сущности адаптивных изображений
     * недостающие создаст
     */
    public function getImages() {
        $models = [];
        
        $sizes = self::getImgSizes();
        foreach ($sizes as $name => $size) {
            $models[] = $this->getAdaptyImg($name, $sizes);
        }
        
        return $models;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTextBlockImages()
    {
        return $this->hasMany(TextBlockImages::className(), ['text_block_id' => 'id']);
    }
    
    /**
     * вернет сущности адаптивного изображения
     * 
     * если такого нету- создаст
     * 
     * @return TextBlockImages
     */
    public function getAdaptyImg($name, $sizes) {
        if(!isset($sizes[$name])) {
            return null;
        }
        $size = $sizes[$name];
        
        $model = $this
                ->getTextBlockImages()
                ->where([
                    'name' => $name,
                ])
                ->one();
        
        if(!$model) {
            $model = new TextBlockImages;
            $model->text_block_id = $this->id;
            $model->name = $name;
            $model->width = $size['width'];
            $model->height = $size['height'];
            $model->min_width = $size['min_width'];
            $model->save();
        }
        
        return $model;
    }
    
    /**
     * удаляем картинку
     */
    public function deleteImg() {
        if(!empty($this->image) && is_file($this->image)) {
            unlink($this->image);
        }        
        $this->image = null;
    }
    
    /**
     * возвращаем размеры изображений для адаптивности
     * по ключу
     */
    public static function getImgSizes() {
        return ImageSizes::get(self::$CurrentSizeId);
    }
}