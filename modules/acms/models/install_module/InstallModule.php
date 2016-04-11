<?php

namespace app\modules\acms\models\install_module;
use app\components\Modules\InstallModule\ScenarioInterface;
use yii\console\controllers\MigrateController;
use yii\db\Migration;

/**
 * Сценарий установки модуля.
 * Установка производится по файлу конфигурации
 *
 * Скануируются виджеты модуля и устанвливаются с настройками доступа
 *
 * Class InstallModule
 * @package app\modules\acms\models\install_module
 */
class InstallModule
{
    const EVENT_BEFORE_INSTALL  = 'event_module_before_install';
    const EVENT_AFTER_INSTALL   = 'event_module_after_install';

    /**
     * конфигурации установки модуля
     *
     * @var array|null
     */
    private $config = null;

    /**
     * путь модуля
     * @var string
     */
    private $path = '';

    public function __construct(array $_config, $_path)
    {
        $this->config = $_config;
        $this->path = $_path;

        //файл предпологаемого сценария устанавливаемого модуля
        $fileScenarioPath = \Yii::$app->basePath . $this->config['scenario'] . '.php';
        //существует ли сценарий
        if(isset($this->config['scenario']) && is_file($fileScenarioPath)) {
            //класс сценария устанавливаемого модуля
            $classScenario = str_replace('/','\\', '/app'.$this->config['scenario']);
            //объект сценария устанавливаемого модуля
            /* @var ScenarioInterface $scenario */
            $scenario = new $classScenario;
            //если сценарий реацилует интерфейс сценария
            if($scenario instanceof ScenarioInterface) {
                $this->addScenarioEvents($scenario);
            }
        }
    }

    /**
     * призявыет слушателей на сценарии
     *
     * @param ScenarioInterface $scenario
     */
    protected function addScenarioEvents(ScenarioInterface $scenario) {
        \Yii::$app->on(self::EVENT_BEFORE_INSTALL,  [$scenario, 'beforeInstall']);
        \Yii::$app->on(self::EVENT_AFTER_INSTALL,   [$scenario, 'afterInstall']);
    }

    /**
     * проверяем на валидность конфиг
     */
    protected function validConfig() {
        return (isset($this->config['@attributes']) &&
            isset($this->config['@attributes']['name']) &&
            isset($this->config['@attributes']['sort']) &&
            isset($this->config['@attributes']['version']));
    }

    //применяем миграции модуля
    protected function migrationsUp($migrationsPath) {
        $migrationPath = '@app' . $migrationsPath;
        $yiiPath = \Yii::$app->basePath . '\\yii';
        exec('php ' . $yiiPath . ' migrate/up all --migrationPath='.$migrationPath . ' --interactive=0');
    }

    /**
     * процесс установки
     *
     * @return bool
     */
    public function install() {
        if(!$this->validConfig()) return false;
        //дергает хендлер предустановки
        \Yii::$app->trigger(self::EVENT_BEFORE_INSTALL);

        //устанавливаем миграции модуля
        if(isset($this->config['migrations']) && $migrationsPath = $this->config['migrations']) {
            $this->migrationsUp($migrationsPath);
        }

        //заносим модуль в базу
        $moduleModel = new \app\modules\acms\models\install_module\Modules;
        $moduleModel->name = $this->config['@attributes']['name'];
        $moduleModel->version = $this->config['@attributes']['version'];
        $moduleModel->sort = $this->config['@attributes']['sort'];
        $moduleModel->path = $this->path;

        if($moduleModel->save()) {
            //устанавливаем виджеты
            if(isset($this->config['widgets'])) {
                $moduleModel->installWidgets($this->config['widgets'], $moduleModel);
            }
        }
        else {
            return false;
        }

        //дергает хендлер постустановки
        \Yii::$app->trigger(self::EVENT_AFTER_INSTALL);

        return true;
    }
}