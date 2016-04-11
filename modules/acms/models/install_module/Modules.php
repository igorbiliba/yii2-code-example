<?php
/**
 * Created by PhpStorm.
 * User: igorb
 * Date: 23.02.16
 * Time: 14:30
 */

namespace app\modules\acms\models\install_module;


use app\modules\acms\models\Widgets;

class Modules extends \app\modules\acms\models\Modules
{
    /**
     * устанавливаем виджеты модуля
     */
    public function installWidgets($widgetsConfig, $module=null) {
        if($module == null) {
            $module = $this;
        }

        if(isset($widgetsConfig['widget'])) {            
            //или несколько виджетов
            if(isset($widgetsConfig['widget']) && isset($widgetsConfig['widget'][0]['@attributes']['name'])) {
                if(count($widgetsConfig['widget']) > 0) {
                    foreach($widgetsConfig['widget'] as $itemConf) {                                                
                        Widgets::createWidget($itemConf, $module);
                    }
                }
            }
            else {//один виджет                
                Widgets::createWidget($widgetsConfig['widget'], $module);
            }
        }
        else {
            return false;
        }
    }
}