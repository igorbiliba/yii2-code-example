<?php

namespace app\modules\module_one;

/**
 * module_one module definition class
 */
class Module extends \app\components\Modules\DynamicModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\module_one\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
