<?php

namespace app\modules\acms\controllers;

use app\modules\acms\components\MixFileActiveDataProvider;
use app\modules\acms\models\modelform\ModuleGeneratorForm;
use app\modules\acms\Module;
use Yii;
use app\models\Modules;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ModulesController implements the CRUD actions for Modules model.
 */
class ModulesController extends Controller
{
    const ACTION_INSTALL = 'install';
    const ACTION_REINSTALL = 'reinstall';    
    const ACTION_UINSTALL = 'uinstall';
    const ACTION_FILEDELETE = 'filedelete';

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
     * Lists all Modules models.
     * @return mixed
     */
    public function actionIndex($action = null, $folder = null)
    {
        \Yii::$app->session->removeAllFlashes();
        //дейсвия с модулями
        if(!empty($action)) {
            switch($action) {
                case self::ACTION_REINSTALL:
                    $model = \app\modules\acms\models\reinstall_module\Modules::findByFolderName($folder);
                    
                    //получим разность установок
                    if($installList = $model->differencesInstanceWidget) {
                        $model->installList = $installList;
                        
                        if($model->reinstall()) {
                            \Yii::$app->session->setFlash('success', \Yii::$app->translate->get('acms_module_is_reinstall'));
                        }
                        else {
                            \Yii::$app->session->setFlash('error', \Yii::$app->translate->get('acms_module_is_not_reinstall'));
                        }
                    }
                    else {
                        \Yii::$app->session->setFlash('error', \Yii::$app->translate->get('acms_module_is_reinstall'));
                    }
                    
                    break;
                case self::ACTION_INSTALL:
                    if(\app\modules\acms\models\Modules::install($folder)) {
                        \Yii::$app->session->setFlash('success', \Yii::$app->translate->get('acms_module_is_install'));
                    }
                    else {
                        \Yii::$app->session->setFlash('error', \Yii::$app->translate->get('acms_module_is_not_install'));
                    }
                    break;
                case self::ACTION_UINSTALL:
                    if(\app\modules\acms\models\Modules::uinstall($folder)) {
                        \Yii::$app->session->setFlash('success', \Yii::$app->translate->get('acms_module_is_delete'));
                    }
                    else {
                        \Yii::$app->session->setFlash('error', \Yii::$app->translate->get('acms_module_is_not_delete'));
                    }
                    break;
                case self::ACTION_FILEDELETE:
                    if(\app\modules\acms\models\Modules::fileDelete($folder)) {
                        \Yii::$app->session->setFlash('success', \Yii::$app->translate->get('acms_module_is_delete_in_filesystem'));
                    }
                    else {
                        \Yii::$app->session->setFlash('error', \Yii::$app->translate->get('acms_module_is_not_delete_in_filesystem'));
                    }
                    break;
            }
        }

        //xml+dir
        $scopeDirInstallParamsXml = \app\modules\acms\models\Modules::scanDirectories();

        //settings install
        $scopeDirInstallParams = \app\modules\acms\models\Modules::parseXmlParams($scopeDirInstallParamsXml);

        //provider = dir + db
        $dataProvider = new MixFileActiveDataProvider([
            'query' => \app\modules\acms\models\Modules::find(),
            'directories' => $scopeDirInstallParams,
        ]);

        return $this->render('template', [
            'content' => $this->renderPartial('index', [
                'dataProvider' => $dataProvider,
            ]),
        ]);
    }

    /**
     * Finds the Modules model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Modules the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Modules::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * генерация модуля
     *
     * @return string
     */
    public function actionGenerate() {
        \Yii::$app->session->removeAllFlashes();
        $model = new ModuleGeneratorForm();
        if ($model->load(Yii::$app->request->post()) && $model->generate()) {
            \Yii::$app->session->setFlash('success', \Yii::$app->translate->get('acms_module_is_generated', [
                '{module_name}' => $model->name,
            ]));
        }
        
        return $this->render('template', [
            'content' => $this->renderPartial('generate', [
                'model' => $model,
            ]),
        ]);
    }
}
