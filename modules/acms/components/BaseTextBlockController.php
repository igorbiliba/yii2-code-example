<?php

namespace app\modules\acms\components;

use Yii;
use app\modules\acms\models\TextBlock;
use app\modules\acms\models\TextBlockSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * базовый класс работы с контентными блоками и текстовыми страницами
 * 
 * у них схожая реаотзация, отлиается лишь пометка типа в базе
 */
class BaseTextBlockController extends Controller
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
     * перегрузить в наследнике
     * 
     * для выборки по нужному типу
     * 
     * @return TextBlockSearch
     */
    protected function getTextBlockSearch() {
        return new TextBlockSearch();
    }
    
    /**
     * перегрузить в наследнике
     * 
     * для создании модели нужного типа
     * 
     * @return TextBlockSearch
     */
    protected function getCreateModel() {
        return new TextBlock();
    }

    /**
     * Lists all TextBlock models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = $this->getTextBlockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@app/modules/acms/views/text_block/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new TextBlock model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = $this->getCreateModel();
        
        $model->is_active     = 1;
        $model->is_use_editor = 1;

        if($model->load(Yii::$app->request->post())) {
            //загрузим картинку
            if($model->imageFile = UploadedFile::getInstance($model, 'imageFile'))
                $model->upload();

            $model->imageFile = null;
            if($model->save()) {
                $this->redirect(['update', 'id' => $model->id]);
            }
        }
        
        return $this->render('@app/modules/acms/views/text_block/create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TextBlock model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $lang_id = -1)
    {
        $model = $this->findModel($id);
        
        $translate = null;
        
        if($lang_id < 1) {
            $lang_id = $model->defaultTBLanguage->language_id;
        }
        
        //язык стандартного перевода
        if($lang_id == $model->defaultTBLanguage->language_id) {
            
            if($model->load(Yii::$app->request->post())) {
                if($model->clear) $model->deleteImg();
                //загрузим картинку
                if($model->imageFile = UploadedFile::getInstance($model, 'imageFile'))
                    $model->upload();
                
                $model->imageFile = null;
                $model->save();
            }
        }
        else {//пришел перевод на другой язык, кроме стандартного            
            $translate = \app\models\TextBlockLanguages::find()
                    ->where([
                        'text_block_id' => $id,
                        'language_id' => $lang_id,
                    ])->one();
            
            if($translate)
                ($translate->load(Yii::$app->request->post()) && $translate->save());
        }
        
        return $this->render('@app/modules/acms/views/text_block/update', [
                'model' => $model,
                'lang_id' => $lang_id,
                'translate' => $translate,
            ]);
    }

    /**
     * Deletes an existing TextBlock model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TextBlock model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TextBlock the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TextBlock::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * загрузка/удаление/изменение данных о
     * изображениях для адаптивности
     * 
     * @param type $id
     * @return type
     */
    public function actionImages($id)
    {
        \Yii::$app->controller->enableCsrfValidation = false;
        
        $model = new \app\modules\acms\models\form\TBImagesForm;
        $model->model = $this->findModel($id);
        
        ($model->load(Yii::$app->request->post()));
        
        return $this->render('@app/modules/acms/views/text_block/images', [
            'model' => $model->model,
        ]);
    }
}
