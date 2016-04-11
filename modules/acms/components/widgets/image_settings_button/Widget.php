<?php
namespace app\modules\acms\components\widgets\image_settings_button;

use \yii\helpers\Html;

class Widget extends \yii\base\Widget {    
    public $size_id;
    
    public function run() {
        $model = \app\modules\acms\models\ImageSizes::find()
                ->where([
                    'key' => $this->size_id,
                ])->one();
        
        return Html::a(\Yii::$app->translate->get('acms_button_edit_adapty_imgs'), [
            '/acms/images/update', 'id' => $model->id
        ], [
            'class' => 'btn btn-success',
        ]);
    }
}