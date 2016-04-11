<?php

namespace app\modules\acms\controllers;

/**
 * Контроллер работы с текстовыми блоками
 */
class TextpageController extends \app\modules\acms\components\BaseTextBlockController
{
    public function beforeAction($action) {
        //устанавливаем ид изображений для адаптивности
        \app\modules\acms\models\TextBlock::$CurrentSizeId = 'TEXT_PAGE';        
        return parent::beforeAction($action);
    }
    
    /**
     * говорим модели что нужно искать 
     * только текстовые страницы
     * 
     * @return \app\modules\acms\models\TextBlockSearch
     */
    protected function getTextBlockSearch() {
        $model = new \app\modules\acms\models\TextBlockSearch();        
        $model->type = \app\modules\acms\models\TextBlock::TYPE_TEXT_PAGE;        
        return $model;
    }
    
    /**
     * создаем модель типа текстовая страница
     * 
     * @return \app\modules\acms\models\TextBlock
     */
    protected function getCreateModel() {
        $model = new \app\modules\acms\models\TextBlock();
        $model->type = \app\modules\acms\models\TextBlock::TYPE_TEXT_PAGE;
        return $model;
    }
}
