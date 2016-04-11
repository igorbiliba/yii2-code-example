<?php
namespace app\modules\acms\models;

class LayoutSettings extends \app\models\LayoutMenu
{
    public $name;
    
    public function getMatches($param = null) {
        $render = new \app\components\render\RenderDynamicTemplate($this->layout_path);        
        
        if($param === null) {
            return $render->matches;
        }
        else {            
            $matches = $render->matches;
            return is_array($matches[$param]) ? $matches[$param] : [];
        }
    }
    
    /**
     * получим параметры переменных в шаблоне
     * из формы
     * 
     * @param type $post
     */
    public function loadAndSave($post) {        
        if(isset($post[$this->formName()])) {
            $list = $post[$this->formName()];
            
            if(is_array($list)) {
                foreach ($list as $name => $item) {
                    if(isset($item['template']) && isset($item['menu'])) {                        
                        LayoutSettingsItem::set($this->id, $name, $item['template'], $item['menu']);                        
                    }
                }
            }
        }
        
        return true;
    }

    /**
     * найдет, либо создаст запись о этом шаблоне
     */
    public static function findOrCreate($layout_path) {
        //если пришел рустой параметр, вернем найдем шаблон из списка
        if($layout_path == null) {
            $templates = \app\models\DymanicTemplates::getListTemplates(\app\models\DymanicTemplates::FOLDER_DYNAMIC_LAYOUTS);
            if(is_array($templates) && count($templates) > 0) {
                $first = array_shift($templates);                
                $layout_path = '@app'.\app\models\DymanicTemplates::FOLDER_DYNAMIC_LAYOUTS.'/'.$first;                
            }
        }
        
        if(!empty($layout_path) && \app\models\DymanicTemplates::isTemplate($layout_path)) {
            //найдем, либо создадим модель по этому шаблону
            $model = self::find()->where([
                'layout_path' => $layout_path
            ])->one();
            
            if(!$model) {
                $model = new self;
                $model->layout_path = $layout_path;
                
                $model->save();
            }
            
            return $model;
        }
        
        return null;
    }
    
    /**
     * для устновки по умолчанию
     */
    public function setDefault() {
        self::updateAll([
            'is_default' => 0,
        ]);
        
        $this->is_default = 1;
        
        return $this->save();
    }
}