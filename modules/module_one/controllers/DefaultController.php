<?php

namespace app\modules\module_one\controllers;

use yii\web\Controller;

/**
 * Default controller for the `module_one` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
