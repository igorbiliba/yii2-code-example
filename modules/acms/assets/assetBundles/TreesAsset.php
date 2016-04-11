<?php
/**
 * Created by PhpStorm.
 * User: igorb
 * Date: 25.02.16
 * Time: 17:02
 */

namespace app\modules\acms\assets\assetBundles;

use yii\web\AssetBundle;
class TreesAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/acms/assets/js';

    public $js = [
        'admin_trees.js',
        'admin_struct_page.js',
        'admin_modal_work_varibles.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}