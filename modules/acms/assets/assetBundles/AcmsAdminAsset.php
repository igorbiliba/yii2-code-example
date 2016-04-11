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
class AcmsAdminAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/acms/assets/js';

    public $js = [
        'acms_admin.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}