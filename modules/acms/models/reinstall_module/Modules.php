<?php

namespace app\modules\acms\models\reinstall_module;

/**
 * модель переустановки виджетов модуля
 */
class Modules extends \app\modules\acms\models\install_module\Modules {
    
    /**
     * лист доустановок
     *
     * @var type 
     */
    public $installList=null;
    
    /**
     ищем модель по пути установки
     * 
     * @param type $folder
     * @return \app\modules\acms\models\reinstall_module\Modules
     */
    public static function findByFolderName($folder) {
        $moduleFolder = self::MODULES_DIR . $folder;
        
        return self::findOne([
            'path' => $moduleFolder
        ]);
    }
    
    /**
     * переустановка модуля
     * 
     * @return boolean
     */
    public function reinstall() {
        $reinstall = new ReinstallModule($this);
        
        return $reinstall->reinstall();
    }
}
