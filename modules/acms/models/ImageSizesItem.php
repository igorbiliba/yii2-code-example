<?php

namespace app\modules\acms\models;

class ImageSizesItem extends \app\models\ImageSizesItem {    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_size_id' => 'Image Size ID',
            'name' => \Yii::$app->translate->get('acms_name'),
            'width' => \Yii::$app->translate->get('acms_width'),
            'height' => \Yii::$app->translate->get('acms_height'),
            'min_width' => \Yii::$app->translate->get('acms_min_width'),
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    public function getInputName($attribute) {
        return $this->getArrFormName() . "[$this->id]" . "[$attribute]";
    }
    
    public function getArrFormName() {
        $formName = $this->formName();
        return $formName . "_arr";
    }
}
