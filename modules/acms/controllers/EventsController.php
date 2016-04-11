<?php

namespace app\modules\acms\controllers;

use Yii;
use app\models\PostEvents;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EventsController implements the CRUD actions for PostEvents model.
 */
class EventsController extends Controller
{
    /**
     * Lists all PostEvents models.
     * @return mixed
     */
    public function actionIndex()
    {
        /*$dataProvider = new ActiveDataProvider([
            'query' => PostEvents::find()->notCopy(),
        ]);*/
        
        $searchModel = New \app\modules\acms\models\EventsSearch(); 
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * удаляет пачку идентификаторов
     * 
     * @param integer $idx
     * @return int
     */
    public function actionDelete($idx)
    {        
        if(!empty($idx)) {            
            $list = explode(',', $idx);            
            if(count($list) > 0) {                
                foreach ($list as $id) {
                    $model = $this->findModel($id);                    
                    if($model != null) {
                        $model->delete();
                    }
                }                
                return 1;
            }
        }        
        return 0;
    }

    /**
     * Finds the PostEvents model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PostEvents the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PostEvents::findOne($id)) !== null) {
            return $model;
        } else {
            //throw new NotFoundHttpException('The requested page does not exist.');
        }
        
        return null;
    }
}
