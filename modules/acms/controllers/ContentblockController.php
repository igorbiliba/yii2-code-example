<?php

namespace app\modules\acms\controllers;

/**
 * Контроллер работы с контентными блоками
 */
class ContentblockController extends \app\modules\acms\components\BaseTextBlockController
{
    public function beforeAction($action) {
        //устанавливаем ид изображений для адаптивности
        \app\modules\acms\models\TextBlock::$CurrentSizeId = 'CONTENT_BLOCK';        
        return parent::beforeAction($action);
    }


    /**
     * говорим модели что нужно искать 
     * только контентные блоки
     * 
     * @return \app\modules\acms\models\TextBlockSearch
     */
    protected function getTextBlockSearch() {
        $model = new \app\modules\acms\models\TextBlockSearch();        
        $model->type = \app\modules\acms\models\TextBlock::TYPE_CONTENT_BLOCK;        
        return $model;
    }
    
    /**
     * создаем модель типа контентный блок
     * 
     * @return \app\modules\acms\models\TextBlock
     */
    protected function getCreateModel() {
        $model = new \app\modules\acms\models\TextBlock();
        $model->type = \app\modules\acms\models\TextBlock::TYPE_CONTENT_BLOCK;
        return $model;
    }
}
