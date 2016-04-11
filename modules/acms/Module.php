<?php

namespace app\modules\acms;

class Module extends \yii\base\Module
{
    const ADMIN_LAYOUT = '@app/modules/acms/views/layouts/main';
    public $controllerNamespace = 'app\modules\acms\controllers';

    public function init()
    {
        parent::init();
        //ассет бандл для всей админки acms
        \app\modules\acms\assets\assetBundles\AcmsAdminAsset::register(\Yii::$app->view);     
        \app\modules\acms\assets\assetBundles\AcmsAdminCssAsset::register(\Yii::$app->view);
    }
    
    public function beforeAction($action) {
        if(parent::beforeAction($action)) {        
            \Yii::$app->controller->layout = self::ADMIN_LAYOUT;            
            return true;
        }        
        return false;
    }
}
