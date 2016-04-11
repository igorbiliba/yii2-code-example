<?php
namespace app\modules\acms\models;

/**
 * ищет файлы wiki
 */
class Wiki extends \yii\base\Component
{
    public $name;
    
    /**
     * путь к каталогу wiki.
     */
    const PATH = '/modules/acms/wiki';
    
    /**
     * расширение для файла wiki
     */
    const EXT = '.html';
    
    /**
     * ищет файлы wiki
     */
    public static function findAll() {
        $ret = [];
        
        $path = self::getPath();
        
        $list = scandir($path);
        
        foreach ($list as $file) {
            if(strpos($file, self::EXT) > 0) {
                $model = new self;
                $model->name = str_replace(self::EXT, '', $file);
                
                $ret[] = $model;
            }
        }
        
        return $ret;
    }
    
    protected static function getPath() {
        return \Yii::$app->basePath . self::PATH;
    }

    /**
     * ищет конкретный файл wiki
     */
    public static function findOne($filename) {
        $file = self::getPath() . '/' . $filename . self::EXT;
        if(is_file($file)) {
            $model = new self;
            $model->name = $filename;
            
            return $model;
        }
        
        return null;
    }
    
    /**
     * вернем контент файла
     * 
     * @return int
     */
    public function getContent() {
        $file = self::getPath() . '/' . $this->name . self::EXT;
        if(is_file($file)) {
            return file_get_contents($file);
        }
        
        return null;
    }
}