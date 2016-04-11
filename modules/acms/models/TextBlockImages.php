<?php
namespace app\modules\acms\models;

use yii\imagine\Image;

class TextBlockImages extends \app\models\TextBlockImages {
    
    /**
     * @var UploadedFile
     */
    public $imageFile;
    
    /**
     * флаг на удаление картинки
     *
     * @var type 
     */
    public $clear;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return \yii\helpers\ArrayHelper::merge(parent::rules(), [
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['clear'], 'integer'],
        ]);
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $this->deleteImg();
            
            $dir = \Yii::$app->basePath . '/web/images/content_blocks/'.$this->name;
            
            if(!is_dir($dir)) {
                mkdir($dir);
            }
            
            $this->image = $dir . '/' . md5($this->id . '_'. rand(9999999, 99999999).'_'.time()) . '.' . $this->imageFile->extension;            
            $this->imageFile->saveAs($this->image);
            
            $this->crop();
            
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * имя в виде массива
     * 
     * @param type $attribute
     * @return type
     */
    public function getInputName($attribute) {
        $formName = $this->formName();
        return $formName . "[$this->id]" . "[$attribute]";
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
     * обрезать по параметраим из базы
     */
    public function crop() {        
        Image::thumbnail($this->image, $this->width, $this->height)
                ->save($this->image, ['quality' => 70]);
    }
}