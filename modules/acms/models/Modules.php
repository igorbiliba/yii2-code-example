<?php
namespace app\modules\acms\models;
use app\modules\acms\models\install_module\InstallModule;
use app\modules\acms\models\install_module\UinstallModule;
use Faker\Provider\File;
use light\yii2\XmlParser;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseFileHelper;

/**
 * модель, которая сканирует папку модулей и список
 * с установленными и не установленными
 */
class Modules extends \app\models\Modules {
    const MODULES_DIR = '/modules/';
    const FILE_INSTALL = 'Install.xml';

    //поврежденный конфиг устновки
    const ERROR_INSTALL_BAD_CONFIG = 0;

    //установлен
    const STATUS_INSTALL = 0;
    //не установлен
    const STATUS_NOT_INSTALL = 1;
    //поврежден
    const STATUS_WRONG = 2;

    //ошибки скинирования модулей
    public $errorInstall = null;

    //папка модуля
    public $folder = null;

    /**
     * сканирует дирректории модулей
     *
     * возвращает файл настроек
     * и полный путь к корню модуля
     *
     * @return array
     */
    public static function scanDirectories() {
        $listModulesXml = [];

        $dirModules = self::getFullPathModulesDir();
        $listFolders = scandir($dirModules);
        foreach ($listFolders as $folderName) {
            //полный путь к каталогу
            $fullFolderName = $dirModules . $folderName;
            //если каталог сущействует и у него валидный путь
            if(preg_match('/^[\w]+$/', $folderName) && is_dir($fullFolderName)) {
                //если есть файл установки модуля
                $fileInstall = $fullFolderName.'/'.self::FILE_INSTALL;
                if(is_file($fileInstall)) {
                    //добавляем в перечень модулей
                    $listModulesXml[] = [
                        'full_folder' => $fullFolderName,
                        'folder' => $folderName,
                        'install' => $fileInstall,
                    ];
                }
            }
        }

        return $listModulesXml;
    }

    /**
     * возвращаем файл конвигурации модуля
     */
    public function getXmlCurrentModule() {        
        $xmlFilePath = \Yii::$app->basePath . $this->path . '/' . self::FILE_INSTALL;
        
        if(is_file($xmlFilePath)) {
            $xmlParser = new XmlParser();
            return $xmlParser->parse(file_get_contents($xmlFilePath), 'text/xml');
        }
        
        return null;
    }


    /**
     * полный путь к дирректории модулей
     *
     * @return string
     */
    public static function getFullPathModulesDir() {
        return \Yii::$app->basePath . self::MODULES_DIR;
    }

    /**
     * парсит файл конфигурации для устновки
     *
     * возвращает набор параметров для установки
     *
     * @param array $list
     */
    public static function parseXmlParams($list = []) {
        $settings = [];

        if($list && is_array($list)) {
            foreach($list as $item) {
                if(isset($item['folder']) && isset($item['install']) && isset($item['full_folder'])) {
                    $xml = file_get_contents($item['install']);

                    $xmlParser = new XmlParser();
                    $data = $xmlParser->parse($xml, 'text/xml');
                    $data['full_folder'] = $item['full_folder'];
                    $data['folder'] = $item['folder'];

                    $settings[] = $data;
                }
            }
        }

        return $settings;
    }

    /**
     * говорит установлен ли модуль
     * 
     *
     * @return bool
     */
    public function getIsInstallStatus() {
        if($this->loadByPath($this->folder)) {
            //если нужно переустановить виджеты
            if(!empty($this->differencesInstanceWidget)) {
                return 2;//требует переустановку виджетов
            }
            
            return 1;//установлен, все ок
        }
        
        return 0;//не установлен
    }
    
    /**
     * возвращает рвзличия
     * между файлом установки и установленными виджетами
     * 
     * @return boolean
     */
    protected function getDifferencesInstanceWidget() {
        //массив, который содержит разность файла и базы
        $ret = [];
        
        //полный путь к модулю
        $fullPath = \Yii::$app->basePath . $this->path;
        $pathFileInstall = $fullPath . '/' . self::FILE_INSTALL;
        //если файл установки существует, то продолжаем
        if(is_file($pathFileInstall)) {
            //закгружаем конфиг
            $configXml = file_get_contents($pathFileInstall);
            
            //парсим конфиг
            $xmlParser = new XmlParser();
            $config = $xmlParser->parse($configXml, 'text/xml');
            
            //ищем виджеты
            if(isset($config['widgets'])) {
                $scopeWidgets = $config['widgets'];
                
                //перебираем виждеты из конфига
                if(isset($scopeWidgets['widget'])) {                    
                    if(is_array($scopeWidgets['widget'])) {
                        //список существующих виджетов конфига
                        $listWidgets = $scopeWidgets['widget'];                                                
                        //проверяем существуют ли такие виджеты в базе
                        foreach ($listWidgets as $widget) {                                                        
                            $className = null;
                            if(isset($widget['class'])) {
                                $className = $widget['class'];
                            }
                            else {
                                if(isset($widget['@attributes']['class'])) {
                                    $className = $widget['@attributes']['class'];
                                }
                            }
                            
                            //есть ли класс виджета
                            if($className) {
                                if(!empty($className)) {                                    
                                    //ищем в базе установленных виджетов
                                    $instanceWidget = \app\models\Widgets::find()
                                        ->where([
                                            'path' => $className,
                                        ])
                                        ->one();
                                    if(!$instanceWidget) {//если виджет не найден
                                        //добавим в разность виджетов
                                        $ret[] = $widget;
                                    }                                    
                                }
                            }//!есть ли класс виджета                   
                        }//!проверяем существуют ли такие виджеты в базе
                    }                    
                }//!перебираем виждеты из конфига
            }//!ищем виджеты
        }

        return $ret;
    }

    /**
     * загружает модель по пути к модулю
     *
     * @param $path
     * @return bool
     */
    protected function loadByPath($path) {
        $model = self::findOne(['path' => self::MODULES_DIR . $path]);

        if($model) {
            $this->attributes = $model->attributes;
            return true;
        }

        return false;
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'isInstallStatus' => \Yii::$app->translate->get('acms_action'),
                'status' => \Yii::$app->translate->get('acms_status'),
            ]
        );
    }

    /**
     * установлен/не установлен/не корректно удален(поврежден)
     *
     * @return int
     */
    public function getStatus() {
        if($this->id > 0 && !$this->issetModuleFolder) return self::STATUS_WRONG;
        if($this->isInstallStatus) return self::STATUS_INSTALL;
        return self::STATUS_NOT_INSTALL;
    }

    /**
     * существует ли модуль по адресу
     */
    protected function getIssetModuleFolder() {
        return is_dir(\Yii::$app->basePath . $this->path);
    }

    /**
     * установка модуля
     *
     * @param string $folder
     */
    public static function install($folder) {
        $fullPath = self::getFullPathModulesDir() . $folder;

        //если модуль не установлен, то продолжаем
        $folderRoot = self::MODULES_DIR.$folder;
        if(!self::findOne(['path' => $folderRoot])) {
            $pathFileInstall = $fullPath . '/' . self::FILE_INSTALL;

            if(is_file($pathFileInstall)) {
                $configXml = file_get_contents($pathFileInstall);

                $xmlParser = new XmlParser();
                $config = $xmlParser->parse($configXml, 'text/xml');

                try {
                    $installModule = new InstallModule($config, $folderRoot);
                    return $installModule->install();
                }
                catch(Exception $e) {
                    return false;
                }
            }
        }

        return false;
    }

    /**
     * удаление модуля
     *
     * @param string $folder
     */
    public static function uinstall($folder) {
        $fullPath = self::getFullPathModulesDir() . $folder;

        //если модуль установлен, то продолжаем
        $folderBuRoot = self::MODULES_DIR.$folder;
        if(self::findOne(['path' => $folderBuRoot])) {
            $pathFileInstall = $fullPath . '/' . self::FILE_INSTALL;

            if(is_file($pathFileInstall)) {
                $configXml = file_get_contents($pathFileInstall);

                $xmlParser = new XmlParser();
                $config = $xmlParser->parse($configXml, 'text/xml');

                try {
                    $installModule = new \app\modules\acms\models\uinstall_module\UinstallModule($config, $folderBuRoot);
                    return $installModule->uinstall();
                }
                catch(Exception $e) {
                    return false;
                }
            }
        }

        return false;
    }

    /**
     * модуля из фаловой системы
     *
     * @param string $folder
     */
    public static function fileDelete($folder) {
        $fullPath = self::getFullPathModulesDir() . $folder;

        //нельзя удалять не динамические модули
        if(!is_file($fullPath.'/'.self::FILE_INSTALL)) return false;

        BaseFileHelper::removeDirectory($fullPath);

        return true;
    }
}