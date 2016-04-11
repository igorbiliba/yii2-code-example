<?php

namespace app\modules\acms\components\virtualTemplate\replaces;

use \yii\helpers\Html;
use \app\models\LinkContents;

/**
* трейт пустых элементов
*/
trait FreeTemplateTrait {
    /**
     * вернем шаблон на добавление
     */
    public static function getFreeContent(LinkContents $model = null) {
        $key = '&nbsp;';
        
        if($model) {
            $key = $model->key;
        }
        
        $content = Html::label($key, null, [
            'class' => 'label label-info'
        ]);
        
        return Html::tag('div', $content, [
            'class' => 'acms_var_template glyphicon glyphicon-plus text-center',
            'data-toggle' => 'tooltip',
            'data-placement' => 'top',
            'title' => \Yii::$app->translate->get('acms_add_new_block'),
            'data-variable' => $model->key,
            'data-link-id' => $model->link_id,
            'data-is-array' => $model->isArray,
            'data-sort' => $model->sort,
        ]);
    }
}