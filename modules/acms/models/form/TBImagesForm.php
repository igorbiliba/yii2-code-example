<?php

namespace app\modules\acms\models\form;

use yii\base\Model;

/**
 * для множественной загрузки картинок 
 * для тектового блока
 */
class TBImagesForm extends Model
{
    /**
     *
     * @var \app\modules\acms\models\TextBlockImages[]
     */
    private $models=[];


    /**
     *
     * @var \app\modules\acms\models\TextBlock
     */
    public $model;

    /**
     * загружаем изображения для адаприности
     * на сервер
     * 
     * @param type $data
     * @param type $formName
     * @return boolean
     */
    public function load($data, $formName = null) {        
        //получаем имя формы с массивом изрдражений и текта
        $formName = (new \app\modules\acms\models\TextBlockImages())->formName();
        //смотри если ли массив имени формы TextBlockImages
        if(isset($data[$formName])) {
            //данные по формам
            $list = $data[$formName];            
            if(is_array($list) && count($list) > 0) {
                //идем по всем элементам TextBlockImages
                foreach ($list as $key => $item) {
                    /* @var \app\modules\acms\models\TextBlockImages */
                    $imageModel = \app\modules\acms\models\TextBlockImages::find()
                            ->where(['id' => $key])
                            ->one();
                    
                    //загружаем и сохраняем модель
                    if($imageModel) {
                        if($imageModel->load([$formName => $item])) {
                            if($imageModel->clear) {//если картинка помечена на удаление                                
                                $imageModel->deleteImg();
                            }
                            //згружаем картинку
                            if($imageModel->imageFile = \yii\web\UploadedFile::getInstanceByName($imageModel->getInputName('imageFile')))
                                $imageModel->upload();

                            $imageModel->imageFile = null;

                            $imageModel->save();
                        }
                    }
                }
            }
            
            true;
        }
        
        return false;
    }
    
    
}