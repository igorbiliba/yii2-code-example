<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property integer $is_active
 * @property string $type
 * @property string $created_at
 * @property string $updated_at
 *
 * @property MenuItem[] $menuItems
 * @property MenuLanguage[] $menuLanguages
 */
class Menu extends \yii\db\ActiveRecord
{
    const TYPE_INNER = 'inner';
    const TYPE_DEFAULT = 'default';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active'], 'integer'],
            [['type'], 'string'],
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
            'is_active' => \Yii::$app->translate->get('acms_is_active'),
            'type' => \Yii::$app->translate->get('acms_type'),
            'name' => \Yii::$app->translate->get('acms_name'),
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItems()
    {
        return $this->hasMany(MenuItem::className(), ['menu_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuLanguages()
    {
        return $this->hasMany(MenuLanguage::className(), ['menu_id' => 'id']);
    }
    
    /**
     * вернет, или создаст перевод меню по умолчанию
     * 
     * @return MenuLanguage
     */
    protected function getDefaultMenuLanguage() {
        //язык по умолчанию, либо выбранный
        $lang = \app\modules\acms\models\Languages::getDefaultLanguage();
        
        if($lang) {
            //ищем модель с этим языком
            $model = $this->getMenuLanguages()
                        ->where([
                            'language_id' => $lang->id,
                        ])
                        ->one();
            
            //если модели перевода нет, значит создадим новую
            if(!$model && ($this->id > 0)) {
                $model = new MenuLanguage();
                $model->language_id = $lang->id;
                $model->menu_id = $this->id;
                
                if($model->save()) {
                    return $model;
                }
            }
            
            return $model;
        }
        
        return null;
    }
    
    /**
     * получаем название меню
     * 
     * @return int
     */
    public function getName() {
        $translate = $this
                ->getMenuLanguages()
                ->where('(name <> "" AND name IS NOT NULL)')->one();
        
        if($translate) {
            return $translate->name;
        }
        
        return '';
    }
    
    public function beforeDelete() {
        if(parent::beforeDelete()) {            
            /**
            * сначала удалим зависимости меню
            */
           foreach ($this->menuLanguages as $model) {
               $model->delete();
           }
            
            return true;
        }
        return false;
    }
}
