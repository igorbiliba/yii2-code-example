<?php
namespace app\components\Modules;

/**
 * базовый класс для динамических модулей
 */
class DynamicModule extends \yii\base\Module
{
    public $layout = '@app/modules/acms/views/layouts/other_modules';
}