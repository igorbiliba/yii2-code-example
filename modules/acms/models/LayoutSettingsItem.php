<?php
namespace app\modules\acms\models;

class LayoutSettingsItem extends \app\models\LayoutMenuItems
{
    /**
     * изменит, или создаст модель с
     * этими параметрами
     * 
     * @param type $layout_menu_id
     * @param type $variable
     * @param type $menu_template
     */
    public static function set($layout_menu_id, $variable, $menu_template, $menu_id) {                
        $model = self::find()
                ->where([
                    'variable' => $variable,
                    'layout_menu_id' => $layout_menu_id
                ])->one();
        
        if(!$model) {            
            $model = new self;
            $model->variable = $variable;
            $model->layout_menu_id = $layout_menu_id;            
        }
        
        $model->menu_id = $menu_id;        
        $model->menu_template = $menu_template;
        
        
        return $model->save();
    }
}