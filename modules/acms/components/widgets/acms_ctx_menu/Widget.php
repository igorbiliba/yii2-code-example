<?php

namespace app\modules\acms\components\widgets\acms_ctx_menu;

use kartik\cmenu\ContextMenu;

class Widget extends ContextMenu {
    const CLASS_VARS = '.acms_var_template';

    protected function registerPlugin($name, $element = null, $callback = null, $callbackCon = null) {
        $this->getPluginScript($name, $element, $callback, $callbackCon);

        $script = ' window.registerCtx = function(){ $("' . self::CLASS_VARS . '").contextmenu(' . $this->_hashVar . '); } ';
        $this->registerWidgetJs($script);
    }

}
