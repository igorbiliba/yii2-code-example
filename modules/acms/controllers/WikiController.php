<?php

namespace app\modules\acms\controllers;

/**
 * Контроллер работы с wiki
 */
class WikiController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    
    public function actionIndex() {
        return $this->render('index', [
            'models' => \app\modules\acms\models\Wiki::findAll(),
        ]);
    }
    
    public function actionView($id) {
        $model = \app\modules\acms\models\Wiki::findOne($id);
        
        if($model) {
            return $this->render('view', [
                'model' => $model,
            ]);
        }
        
        throw new Exception("wiki file not found", 404);
    }
}
