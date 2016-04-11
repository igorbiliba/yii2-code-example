<?php
/**
 * Created by PhpStorm.
 * User: igorb
 * Date: 25.02.16
 * Time: 17:02
 */

namespace app\modules\acms\assets\assetBundles;

use yii\web\AssetBundle;
class MenuAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/acms/assets/js';

    public $js = [
        'admin_menu.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}