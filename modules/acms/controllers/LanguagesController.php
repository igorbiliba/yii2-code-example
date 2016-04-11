<?php

namespace app\modules\acms\controllers;

use Yii;
use app\models\Languages;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LanguagesController implements the CRUD actions for Languages model.
 */
class LanguagesController extends Controller
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
     * Lists all Languages models.
     * @return mixed
     */
    public function actionIndex()
    {
        \Yii::$app->session->removeAllFlashes();

        //выбор языка по умочанию
        if($id = Yii::$app->request->get('id')) {
            if(Yii::$app->request->get('is_default')) {
                \app\modules\acms\models\Languages::setIsDefaultById($id);
            }

            $is_active = Yii::$app->request->get('is_active');
            if($is_active !== null) {
                \app\modules\acms\models\Languages::setIsActiveById($id, $is_active);
            }
        }
        //***********************

        //создание языка
        $createModel = new Languages();
        if(Yii::$app->request->isPost) {
            if ($createModel->load(Yii::$app->request->post()) && $createModel->save()) {
                $createModel = new Languages();
                \Yii::$app->session->setFlash('success', \Yii::$app->translate->get('acms_success_add_language'));
            } else {
                \Yii::$app->session->setFlash('error', \Yii::$app->translate->get('acms_error_on_add_language'));
            }
        }
        //*************

        $dataProvider = new ActiveDataProvider([
            'query' => Languages::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $createModel,
        ]);
    }

    /**
     * Deletes an existing Languages model.
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
     * Finds the Languages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Languages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Languages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
}
