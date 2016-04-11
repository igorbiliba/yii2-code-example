<?php

use yii\db\Migration;

class m160322_162651_insert_images_adapty_textblck extends Migration
{
    public function up()
    {
        //добавляем адаптивность для контентного блока
        $sizes = \app\modules\acms\models\ImageSizes::getDefaultSizes();
        \app\modules\acms\models\ImageSizes::create('CONTENT_BLOCK', $sizes);
        
        //добавляем адаптивность для текстовой страницы
        $sizes = \app\modules\acms\models\ImageSizes::getDefaultSizes();
        \app\modules\acms\models\ImageSizes::create('TEXT_PAGE', $sizes);
    }

    public function down()
    {
        $model = \app\modules\acms\models\ImageSizes::find()->where([
            'key' => 'CONTENT_BLOCK',
        ])->one();
        $model->delete();
        
        $model = \app\modules\acms\models\ImageSizes::find()->where([
            'key' => 'TEXT_PAGE',
        ])->one();
        $model->delete();
    }
}
