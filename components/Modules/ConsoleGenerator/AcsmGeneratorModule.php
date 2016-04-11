<?php
namespace app\components\Modules\ConsoleGenerator;

use yii\base\Component;
use yii\helpers\FileHelper;

/**
 * Автонегерация модуля с конфигурацией установки
 *
 * Class AcsmGeneratorModule
 * @package app\components\Modules\ConsoleGenerator
 */
class AcsmGeneratorModule extends Component
{
    const TEMPLATE_PATH         = '/components/Modules/ConsoleGenerator/files';
    const TEMPLATE_EXTENTIONS   = '.template';

    const FOLDER_MODULES        = 'modules';
    const FOLDER_COMPONENTS     = 'components';
    const FOLDER_ASSETS         = 'assest';
    const FOLDER_CSS            = 'css';
    const FOLDER_JS             = 'js';
    const FOLDER_IMAGES         = 'images';
    const FOLDER_ASSETS_BUNDLES = 'assetsBundles';
    const FOLDER_WIDGETS        = 'widgets';
    const FOLDER_MIGRATIONS     = 'migrations';
    const FILE_INSTALL          = 'install.xml';
    const FILE_INSTALL_WIDGET   = 'install_widget.xml';
    const FILE_WIDGET           = 'Widget.php';
    const FILE_SCENARIO         = 'Scenario.php';
    const FILE_CONFIG           = 'config.php';
    const FILE_MODULE_CLASS     = 'Module.php';
    const FOLDER_VIEWS         = 'views';
    
    //каталоги для динамических шаблонов
    const FOLDER_DYNAMIC_CONTENT_BLOCKS = 'acms_dynamic_content_blocks';
    const FOLDER_DYNAMIC_LAYOUTS        = 'acms_dynamic_layouts';
    const FOLDER_DYNAMIC_TEMPLATES      = 'acms_dynamic_templates';
    const FOLDER_DYNAMIC_WIDGETS        = 'acms_dynamic_widgets';

    /**
     * корень модуля
     *
     * @var string
     */
    private $moduleDirectory = null;

    /**
     * @var string
     */
    private $moduleName = null;

    /**
     * @var string
     */
    private $widgetName = null;

    /**
     * ConsoleGeneratorModule constructor.
     * @param string $_moduleName
     */
    public function __construct($_moduleName, $_widgetName)
    {
        $this->moduleName = $_moduleName;
        $this->widgetName = $_widgetName;
        $this->moduleDirectory = \Yii::$app->basePath . '/' . self::FOLDER_MODULES . '/' . $_moduleName;

        //для теста!!!!!!!!!!
        FileHelper::removeDirectory($this->moduleDirectory);
        //*********!!!!!!!!!!
    }

    /**
     * изменим базовый класс модуля на динамический
     */
    protected function updateBaseDynamincModule($serch='\yii\base\Module', $replace='\app\components\Modules\DynamicModule') {        
        $file = $this->moduleDirectory . '/' . self::FILE_MODULE_CLASS;
        if(is_file($file)) {
            $content = file_get_contents($file);            
            $content = str_replace($serch, $replace, $content);            
            $write = fopen($file, 'w');
            fputs($write, $content, strlen($content));
            fclose($write);
            
            return true;
        }
        
        return false;
    }

        /**
     * генерируем скилет модуля с помощью gii
     */
    public function giiGenerateModule() {
        $yii = \Yii::$app->basePath . '/yii';
        exec('php '.$yii.' gii/module --moduleID='.$this->moduleName.' --moduleClass="app\modules\\'.$this->moduleName.'\Module" --interactive=0', $out);
        $this->updateBaseDynamincModule();

        exec('php '.$yii.' gii/controller --controllerClass="app\modules\\'.$this->moduleName.'\controllers\SettingsController" --viewPath="@app/modules/'.$this->moduleName.'/views/settings" --interactive=0', $out2);

        return $out + $out2;
    }

    /**
     * создание дирректории assets
     */
    public function createAssetsDir() {
        $assets = $this->moduleDirectory . '/' . self::FOLDER_ASSETS;
        FileHelper::createDirectory($assets);
        FileHelper::createDirectory($assets.'/'.self::FOLDER_CSS);
        FileHelper::createDirectory($assets.'/'.self::FOLDER_IMAGES);
        FileHelper::createDirectory($assets.'/'.self::FOLDER_JS);
    }

    /**
     * создание дирректории для миграций
     */
    public function createMigrationsDir() {
        FileHelper::createDirectory($this->moduleDirectory.'/'.self::FOLDER_MIGRATIONS);
    }

    /**
     * создание дирректории компонентов
     * создание виджетов
     * создание файла сценария установки
     * создание контроллеров
     * создание дирректории динамических шаблонов
     */
    public function createComponentsScope() {
        $components = $this->moduleDirectory.'/'.self::FOLDER_COMPONENTS;
        FileHelper::createDirectory($components);
        FileHelper::createDirectory($components.'/'.self::FOLDER_ASSETS_BUNDLES);
        FileHelper::createDirectory($components.'/'.self::FOLDER_WIDGETS);       

        //генерируем виджет
        if(!empty($this->widgetName)) {
            $widgetFolder = $components.'/'.self::FOLDER_WIDGETS.'/'.$this->widgetName;
            FileHelper::createDirectory($widgetFolder);
            $copy = new GenerateClassesModule($widgetFolder . '/' . self::FILE_WIDGET);
            $copy->loadTempalte(\Yii::$app->basePath . self::TEMPLATE_PATH . '/' . self::FILE_WIDGET . self::TEMPLATE_EXTENTIONS, [
                '{moduleName}' => $this->moduleName,
                '{widgetName}' => $this->widgetName,
            ]);
            $copy->generate();
        }

        //генерируем файл сценария установки
        $copy = new GenerateClassesModule($components . '/' . self::FILE_SCENARIO);
        $copy->loadTempalte(\Yii::$app->basePath . self::TEMPLATE_PATH . '/' . self::FILE_SCENARIO . self::TEMPLATE_EXTENTIONS, [
            '{moduleName}' => $this->moduleName,
        ]);
        $copy->generate();

        //генерируем файл доп конфигурации модуля
        $copy = new GenerateClassesModule($this->moduleDirectory . '/' . self::FILE_CONFIG);
        $copy->loadTempalte(\Yii::$app->basePath . self::TEMPLATE_PATH . '/' . self::FILE_CONFIG. self::TEMPLATE_EXTENTIONS, [
            '{moduleName}' => $this->moduleName,
            '{widgetName}' => $this->widgetName,
        ]);
        $copy->generate();
        
        //создание дирректории динамических шаблонов
        FileHelper::createDirectory($this->moduleDirectory . '/' . self::FOLDER_VIEWS . '/' . self::FOLDER_DYNAMIC_WIDGETS);
        FileHelper::createDirectory($this->moduleDirectory . '/' . self::FOLDER_VIEWS . '/' . self::FOLDER_DYNAMIC_LAYOUTS);
        FileHelper::createDirectory($this->moduleDirectory . '/' . self::FOLDER_VIEWS . '/' . self::FOLDER_DYNAMIC_TEMPLATES);
        FileHelper::createDirectory($this->moduleDirectory . '/' . self::FOLDER_VIEWS . '/' . self::FOLDER_DYNAMIC_CONTENT_BLOCKS);
    }

    /**
     * генерация инструкции установки
     */
    public function createInstallFile() {
        $copy = new GenerateClassesModule($this->moduleDirectory . '/' . self::FILE_INSTALL);

        $widget = '';

        if(!empty($this->widgetName)) {
            $widget = $copy->loadTempalte(\Yii::$app->basePath . self::TEMPLATE_PATH . '/' . self::FILE_INSTALL_WIDGET . self::TEMPLATE_EXTENTIONS, [
                '{moduleName}' => $this->moduleName,
                '{widgetName}' => $this->widgetName,
            ]);
        }

        $copy->loadTempalte(\Yii::$app->basePath . self::TEMPLATE_PATH . '/' . self::FILE_INSTALL . self::TEMPLATE_EXTENTIONS, [
            '{moduleName}' => $this->moduleName,
            '{widget}' => $widget,
        ]);
        $copy->generate();
    }
}