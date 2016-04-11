<?php

namespace app\components\Modules\InstallModule;

/**
 * интерфейс реализует систему событий установки и удаления модуля
 *
 * Interface ScenarioInterface
 * @package app\components
 */
interface ScenarioInterface {
    public function beforeInstall();
    public function beforeUinstall();

    public function afterInstall();
    public function afterUinstall();
}