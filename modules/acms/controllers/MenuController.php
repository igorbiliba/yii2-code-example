<?php

namespace app\modules\acms\controllers;

use Yii;
use app\modules\acms\models\Menu;
use app\modules\acms\models\MenuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\acms\models\Tree;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends Controller
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

    public function actions() {
        return [
            'nodeChildren' => [
                'class' => 'app\modules\acms\components\menuTrees\NodeChildrenAction',
                'treeModelName' => Tree::className()
            ],
        ];
    }
    
    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Menu();
        $model->type = Menu::TYPE_INNER;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $lang=0)
    {
        $translate = null;
        $model = $this->findModel($id);
        
        if($lang == 0) {//редактируем меню и язык по умолчанию                      
            ($model->load(Yii::$app->request->post()) && $model->save());
        }
        else {//редактируем какой-то язык
            $translate = \app\models\MenuLanguage::find()
                    ->where([
                        'menu_id' => $id,
                        'language_id' => $lang,
                    ])->one();
            
            if(!$translate) {
                $translate = new \app\models\MenuLanguage;
                $translate->language_id = $lang;
                $translate->menu_id = $id;
            }
            
            ($translate->load(Yii::$app->request->post()) && $translate->save());
        }
        
        return $this->render('update', [
            'model'          => $model,
            'translateLang'  => $translate,
            'translates'     => $model->getTranslates(false),
            'lang'           => $lang,
            'struct'         => \app\modules\acms\models\Links::getStruct(),
        ]);
    }

    /**
     * Deletes an existing Menu model.
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
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
