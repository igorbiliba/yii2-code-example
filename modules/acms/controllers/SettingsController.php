<?php

namespace app\modules\acms\controllers;

use Yii;
use app\modules\acms\models\LayoutSettings;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SettingsController implements the CRUD actions for LayoutSettings model.
 */
class SettingsController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    
    public function actionIndex() {
        $this->redirect(['layout']);
    }
    
    /**
     * для устновки по умолчанию
     * 
     * @param type $id
     */
    public function actionDefault_layout($id, $path) {
        
        $model = LayoutSettings::find()->where([
            'id' => $id,
        ])->one();
        
        if($model) {
            $model->setDefault();
        }
        
        $this->redirect(['/acms/settings/layout', 'id' => $path,]);
    }


    public function actionLayout($id=null)
    {
        $model = LayoutSettings::findOrCreate($id);
        
        if(!$model) {
            throw new \yii\web\NotFoundHttpException();
        }
        
        if($model->loadAndSave(\Yii::$app->request->post())) {
            
        }
        
        return $this->render('layout', [
            'model' => $model,
        ]);
    }
}
