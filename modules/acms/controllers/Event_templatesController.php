<?php

namespace app\modules\acms\controllers;

use Yii;
use app\models\PostEventsTemplates;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Event_templatesController implements the CRUD actions for PostEventsTemplates model.
 */
class Event_templatesController extends Controller
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
     * Lists all PostEventsTemplates models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = New \app\modules\acms\models\PostEventsTemplatesSearch(); 
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Creates a new PostEventsTemplates model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PostEventsTemplates();
        $model->delay = 0;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PostEventsTemplates model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $language_id=0)
    {
        //выбранный язык из таба
        $language = \app\modules\acms\models\Languages::findOne(['id' => $language_id]);
        
        //доступные языки
        $languages = \app\modules\acms\models\Languages::find()->active()->all();
        
        //если такой язык отсутствует, берем язык по умолчанию
        if(!$language) {
            foreach ($languages as $item) {
                if($item->is_default) {
                    $language = $item;
                }
            }
        }
        
        $model = $this->findModel($id);
        
        if(!$model) throw new \yii\web\HttpException(404);

        //загрузим языковые настройки шаблона
        $templateLang = \app\models\PostEventsTemplatesLanguages::findOne([
            'template_id' => $model->id,
            'language_id' => $language->id,
        ]);
        
        //если таких настроек нету, создадим
        if(!$templateLang) {
            $templateLang = new \app\models\PostEventsTemplatesLanguages;
            $templateLang->template_id = $model->id;
            $templateLang->language_id = $language->id;
        }
        //cохраняем языковые настройки
        ($templateLang->load(Yii::$app->request->post()) && $templateLang->save());
        
        //сохраняем общие настройки письма
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'language_id' => $language->id,
                'languages' => $languages,
                'model' => $model,
                'templateLang' => $templateLang,
                'defaultSettings' => \app\models\PostEventsSettings::getDefaultSettings(),
            ]);
        }
    }

    /**
     * Deletes an existing PostEventsTemplates model.
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
     * Finds the PostEventsTemplates model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PostEventsTemplates the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PostEventsTemplates::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
