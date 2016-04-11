<?php

namespace app\modules\acms\controllers;

use Yii;
use app\models\PostEventsSettings;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Events_settingsController implements the CRUD actions for PostEventsSettings model.
 */
class Events_settingsController extends Controller
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
     * Lists all PostEventsSettings models.
     * @return mixed
     */
    public function actionIndex($language_id=0)
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
        
        //изменить параметры почты для этого языка
        $model = \app\modules\acms\models\PostEventsSettings::findOne([
            'language_id' => $language->id,
        ]);
        if(!$model) {
            $model = new \app\modules\acms\models\PostEventsSettings;
            $model->language_id = $language->id;
        }

        //если эта настройка не языка по умолчанию
        //скопируем email из настройки по умолчанию
        if(empty($model->from_email)) {
            $model->copyEmailByLangDefault();
        }
        
        \Yii::$app->session->removeAllFlashes();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->addFlash('success', \Yii::$app->translate->get('acms_post_params_for_lang_is_updated', [
                'lang' => $language->name,
            ]));
        }
        //****************************************
        
        return $this->render('index', [            
            'language_id' => $language->id,
            'languages' => $languages,
            'model' => $model,
        ]);
    }

    /**
     * Finds the PostEventsSettings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PostEventsSettings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PostEventsSettings::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
