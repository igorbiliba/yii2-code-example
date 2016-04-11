<?php
/**
 * Created by PhpStorm.
 * User: igorb
 * Date: 25.02.16
 * Time: 17:02
 */

namespace app\modules\acms\assets\assetBundles;

use yii\web\AssetBundle;

/**
 * подключени для всей админки
 * 
 */
class AcmsAdminCssAsset extends AssetBundle
{
    public function init() {
        $this->jsOptions['position'] = \yii\web\View::POS_HEAD;
        parent::init();
    }
    
    public $sourcePath = '@app/modules/acms/assets/css';

    public $css = [
        'acms_admin.css',
    ];
    
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}