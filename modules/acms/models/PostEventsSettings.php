<?php
namespace app\modules\acms\models;

class PostEventsSettings extends \app\models\PostEventsSettings {
    /**
     * вернет все настройки для этого языка
     * 
     * если настройки нету для такого языка. создаст сам.
     */
    public function getSettingsByLanguage($languageId) {
        $model = self::findOne([
            'language_id' => (int)$languageId,
        ]);
        
        //если настройки для этого языка нету. создатим ее
        if(!$model) {
            $model = new self;
            $model->language_id = $languageId;
            
            if(!$model->save()) {                
                return null;
            }
        }
        
        return $model;
    }
    
    /**
     * скопировать E-Mail из настройки по умолчанию
     */
    public function copyEmailByLangDefault() {
        $language = \app\models\Languages::find()->default->one();
        
        if($language) {
            $defaultSettings = $language->postSettings;
            $this->from_email = $defaultSettings->from_email;
        }
    }
}
