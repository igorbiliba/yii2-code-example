<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "text_block".
 *
 * @property integer $id
 * @property string $type
 * @property integer $is_active
 * @property string $image
 * @property integer $is_use_editor
 * @property string $js
 * @property string $created_at
 * @property string $account_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property TextBlockLanguages[] $textBlockLanguages
 */
class TextBlock extends \yii\db\ActiveRecord
{
    const TYPE_CONTENT_BLOCK = 'content_block';
    const TYPE_TEXT_PAGE = 'text_page';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'text_block';
    }

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'js'], 'string'],
            [['is_active', 'is_use_editor', 'account_id'], 'integer'],
            [['image'], 'string', 'max' => 127],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'is_active' => \Yii::$app->translate->get('is_active'),
            'image' => \Yii::$app->translate->get('image'),
            'is_use_editor' => \Yii::$app->translate->get('is_use_editor'),
            'title' => \Yii::$app->translate->get('title'),
            'js' => 'Js',
            'created_at' => \Yii::$app->translate->get('created_at'),
            'updated_at' => \Yii::$app->translate->get('updated_at'),
        ];
    }

    /**
     * вернет, или создаст перевод меню по умолчанию
     * 
     * @return MenuLanguage
     */
    public function getDefaultTBLanguage() {
        //язык по умолчанию, либо выбранный
        $lang = \app\modules\acms\models\Languages::getDefaultLanguage();
        
        if($lang) {
            //ищем модель с этим языком
            $model = $this->getTextBlockLanguages()
                        ->where([
                            'language_id' => $lang->id,
                        ])
                        ->one();
            
            //если модели перевода нет, значит создадим новую
            if(!$model && ($this->id > 0)) {
                $model = new TextBlockLanguages();
                $model->language_id = $lang->id;
                $model->text_block_id = $this->id;
                
                if($model->save()) {
                    return $model;
                }
            }
            
            return $model;
        }
        
        return null;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTextBlockLanguages()
    {
        return $this->hasMany(TextBlockLanguages::className(), ['text_block_id' => 'id']);
    }
    
    /**
     * получаем текст
     * 
     * @return int
     */
    public function getText() {
        //язык по умолчанию, либо выбранный
        $lang = \app\modules\acms\models\Languages::getDefaultLanguage();
        
        $translate = $this
                ->getTextBlockLanguages()
                ->where([
                    'language_id' => $lang->id,
                ])->one();
        
        if($translate) {
            return $translate->text;
        }
        
        return '';
    }
    
    /**
     * получаем заголовок
     * 
     * @return int
     */
    public function getTitle() {
        //язык по умолчанию, либо выбранный
        $lang = \app\modules\acms\models\Languages::getDefaultLanguage();
        
        $translate = $this
                ->getTextBlockLanguages()
                ->where([
                    'language_id' => $lang->id,
                ])->one();
        
        if($translate) {
            return $translate->title;
        }
        
        return '';
    }
    
    public function beforeDelete() {
        if(parent::beforeDelete()) {            
            /**
             * удалим связи сначала
             */
            $tranlates = $this->getTextBlockLanguages()->all();
            foreach ($tranlates as $item) {
                $item->delete();
            }
            
            return true;
        }
        
        return false;
    }
    
    /**
     * вернет картинку, или заглушку под картинку
     */
    public function getImg() {
        if(!empty($this->image) && is_file($this->image)) {
            $names = explode('/', $this->image);
            $name = end($names);
            
            if(strpos($name, '.') > -1) {
                return '/images/content_blocks/origin/' . $name;
            }
        }
        
        return LinkContents::NO_PHOTO;
    }
}
