<?php

namespace app\modules\acms\models\reinstall_module;

use \app\modules\acms\models\reinstall_module\Modules;
use \light\yii2\XmlParser;

/**
 * обрабатывает переустановку виджетов
 */
class ReinstallModule extends \app\modules\acms\models\install_module\InstallModule {
    /**
     * модель модуля
     *
     * @var \app\modules\acms\models\reinstall_module\Modules
     */
    private $module = null;
    
    /**
     * прочитаем конфиг
     * 
     * @param Modules $module
     * @return boolean
     */
    public function __construct(Modules $module) {        
        $this->module = $module;
        $pathFileInstall = \Yii::$app->basePath .  $module->path . '/' . Modules::FILE_INSTALL;
        
        if(is_file($pathFileInstall)) {
            $configXml = file_get_contents($pathFileInstall);

            $xmlParser = new XmlParser();
            $config = $xmlParser->parse($configXml, 'text/xml');

            try {
                parent::__construct($config, $module->path);
            }
            catch(Exception $e) {
            }
        }
    }
    
    /**
     * сама переустановка
     * 
     * @return boolean
     */
    public function reinstall() {
        if(!$this->validConfig()) return false;
        //дергает хендлер предустановки
        \Yii::$app->trigger(self::EVENT_BEFORE_INSTALL);
        
        //устанавливаем миграции модуля
        if(isset($this->config['migrations']) && $migrationsPath = $this->config['migrations']) {
            $this->migrationsUp($migrationsPath);
        }
        
        $this->module->installWidgets([
            'widget' => $this->module->installList,
        ]);
        
        //дергает хендлер постустановки
        \Yii::$app->trigger(self::EVENT_AFTER_INSTALL);
        
        return true;
    }
}
