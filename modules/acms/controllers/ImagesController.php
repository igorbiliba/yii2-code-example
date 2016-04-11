<?php

namespace app\modules\acms\controllers;

use Yii;
use app\modules\acms\models\ImageSizes;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ImageController implements the CRUD actions for ImageSizes model.
 */
class ImagesController extends Controller
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

    /**
     * Updates an existing ImageSizes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $size = $this->createSize($model);        
        $this->updateSizes($model);
        
        return $this->render('update', [
            'model' => $model,
            'modelSize' => $size,
        ]);
    }
    
    /**
     * обновит массив разрешений для
     * этого ключа
     * 
     * @param ImageSizes $key
     */
    protected function updateSizes(ImageSizes $key) {
        $item = new \app\modules\acms\models\ImageSizesItem;
        $formName = $item->getArrFormName();
        
        /**
         * или пришел массив разрешений
         */
        if($attrs = \Yii::$app->request->post($formName)) {
            foreach ($attrs as $id => $val) {
                /* @var $model \app\modules\acms\models\ImageSizesItem */
                $model = \app\modules\acms\models\ImageSizesItem::find()
                        ->where([
                            'id' => $id,
                        ])->one();                
                
                if($model) {                    
                    if($model->load([ $item->formName() => $val ])) {
                        $model->save();
                    }
                }
            }
        }
    }
    
    /**
     * создаст разрешения 
     * для этого ключа
     * 
     * @param ImageSizes $key
     * @return \app\modules\acms\models\ImageSizesItem
     */
    protected function createSize(ImageSizes $key) {
        $model = new \app\modules\acms\models\ImageSizesItem();
        
        $formName = $model->formName();
        
        Yii::$app->session->removeFlash('size_success');
        Yii::$app->session->removeFlash('size_error');
        
        if($attrs = \Yii::$app->request->post($formName)) {
            $model->image_size_id = $key->id;            
            if ($model->load(Yii::$app->request->post())) {
                if($model->save()) {
                    Yii::$app->session->setFlash('size_success', Yii::$app->translate->get('acms_size_success'));
                }
                else {
                    Yii::$app->session->setFlash('size_error', Yii::$app->translate->get('acms_size_error'));
                }
            };
        }
        
        return $model;
    }

    public function actionDelete_size($id) {
        $model = \app\modules\acms\models\ImageSizesItem::find()
                ->where([
                    'id' => $id,
                ])->one();
        
        $keyId = $model->image_size_id;
        
        if($model) {
            $model->delete();
        }
        
        $this->redirect([
            '/acms/images/update', 'id' => $keyId,
        ]);
    }

    /**
     * Finds the ImageSizes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ImageSizes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ImageSizes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
