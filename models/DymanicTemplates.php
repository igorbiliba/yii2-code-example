<?php
namespace app\models;

/**
 * Класс, работает с динамическими шаблонами
 */
class DymanicTemplates {
    const FOLDER_DYNAMIC_TEMPLATES      = '/views/acms_dynamic_templates';
    const FOLDER_DYNAMIC_LAYOUTS        = '/views/acms_dynamic_layouts';
    const FOLDER_DYNAMIC_WIDGETS        = '/views/acms_dynamic_widgets';
    const FOLDER_DYNAMIC_CONTENT_BLOCKS = '/views/acms_dynamic_content_blocks';
    const FOLDER_DYNAMIC_MENU           = '/views/acms_dynamic_menu';
    
    const DEFAULT_EXTEND = '.php';


    /**
     * делает скан шаблонов
     */
    public static function getListTemplates($folder = '/views/acms_dynamic_templates', $addEmpty = false) {        
        $list = [];
        
        if($addEmpty) {
            $list[] = '';
        }

        $pathFolder = \Yii::$app->basePath . $folder;
        
        if(is_dir($pathFolder)) {
            $listFiles = scandir($pathFolder);

            if(is_array($listFiles) && count($listFiles)) {
                foreach($listFiles as $file) {
                    if(strpos($file, self::DEFAULT_EXTEND) > -1) {
                        $path = str_replace(self::DEFAULT_EXTEND, '', $file);
                        $name = str_replace(\Yii::$app->basePath . $folder, '', $path);

                        $list['@app' . $folder . '/' . $path] = \Yii::$app->translate->get($name);
                    }
                }
            }
        }

        return \yii\helpers\ArrayHelper::merge($list, self::getTemplatesInModules());
    }
    
    /**
     * делает скан динамических шаблонов из папок модулей
     */
    protected static function getTemplatesInModules($folder = '/views/acms_dynamic_templates') {
        $list = [];
        
        $modules = Modules::find()
                ->all();
        
        //список каталогов с динамическими шаблонами
        $folders = [];        
        foreach ($modules as $module) {
            $folder = \Yii::$app->basePath . $module->path . $folder;
            
            if(is_dir($folder)) {
                $folders[] = $folder;
            }
        }
        
        //сканы каталогов
        foreach ($folders as $folder) {            
            $listFiles = scandir($folder);

            if(is_array($listFiles) && count($listFiles)) {
                foreach($listFiles as $file) {
                    if(strpos($file, self::DEFAULT_EXTEND) > -1) {
                        $path = str_replace(self::DEFAULT_EXTEND, '', $file);
                        $name = str_replace(\Yii::$app->basePath . $folder, '', $path);

                        $list['@app' . $folder . '/' . $path] = \Yii::$app->translate->get($name);
                    }
                }
            }
        }
        
        return $list;
    }
    
    /**
     * или существует такой файл
     * формата @app/....
     * 
     * @param type $tmpl
     */
    public static function isTemplate($tmpl) {
        $path = \Yii::$app->basePath . str_replace('@app', '', $tmpl).self::DEFAULT_EXTEND;
        return is_file($path);
    }
}
