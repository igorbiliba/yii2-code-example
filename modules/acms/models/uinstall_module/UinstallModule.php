<?php

namespace app\modules\acms\models\uinstall_module;
use app\components\Modules\InstallModule\ScenarioInterface;

/**
 * Сценарий удаления модуля и виджетов.
 * Удаление из базы+ удаление всех зависимостей.
 *
 * Class UinstallModule
 * @package app\modules\acms\models\install_module
 */
class UinstallModule
{
    const EVENT_BEFORE_UINSTALL  = 'event_module_before_uinstall';
    const EVENT_AFTER_UINSTALL   = 'event_module_after_iinstall';

    /**
     * конфигурации удаления модуля
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
        \Yii::$app->on(self::EVENT_BEFORE_UINSTALL,  [$scenario, 'beforeUinstall']);
        \Yii::$app->on(self::EVENT_AFTER_UINSTALL,   [$scenario, 'afterUinstall']);
    }

    /**
     * проверяем на валидность конфиг
     */
    protected function validConfig() {
        return (isset($this->config['@attributes']) &&
            isset($this->config['@attributes']['name']) &&
            isset($this->config['@attributes']['version']));
    }

    //откатываем миграции модуля
    protected function migrationsDown($migrationsPath) {
        $migrationPath = '@app' . $migrationsPath;
        $yiiPath = \Yii::$app->basePath . '\\yii';
        exec('php ' . $yiiPath . ' migrate/down all --migrationPath='.$migrationPath . ' --interactive=0');
    }

    /**
     * процесс удаления
     *
     * @return bool
     */
    public function uinstall() {
        if(!$this->validConfig()) return false;
        //дергает хендлер предустановки
        \Yii::$app->trigger(self::EVENT_BEFORE_UINSTALL);

        /* @var \app\modules\acms\models\uinstall_module\Modules $model */
        $model = \app\modules\acms\models\uinstall_module\Modules::findOne(['path' => $this->path]);
        if(!$model) return false;

        if(!$model->delete()) {
            return false;
        }

        //откатываем миграции модуля
        if(isset($this->config['migrations']) && $migrationsPath = $this->config['migrations']) {
            $this->migrationsDown($migrationsPath);
        }

        //дергает хендлер постустановки
        \Yii::$app->trigger(self::EVENT_AFTER_UINSTALL);

        return true;
    }
}