<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Modules';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modules-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('./../_part/_flash') ?>

    <p>
        <?=Html::a(\Yii::$app->translate->get('acms_view_installed_widgets'), ['/acms/widgets'], [
            'class' => 'btn btn-success'
        ])?>&nbsp;
        <?=Html::a(\Yii::$app->translate->get('acms_generation_module'), ['generate'], [
            'class' => 'btn btn-warning'
        ])?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($model) {
                    switch($model->status) {
                        case \app\modules\acms\models\Modules::STATUS_INSTALL:
                            return Html::label(\Yii::$app->translate->get('acms_installed'), null, [
                                'class' => 'label label-success',
                            ]);
                            break;
                        case \app\modules\acms\models\Modules::STATUS_NOT_INSTALL:
                            return Html::label(\Yii::$app->translate->get('acms_not_installed'), null, [
                                'class' => 'label label-warning',
                            ]);
                            break;
                        case \app\modules\acms\models\Modules::STATUS_WRONG:
                            return Html::label(\Yii::$app->translate->get('acms_is_not_valid'), null, [
                                'class' => 'label label-danger',
                            ]);
                            break;
                        default:
                            return '';
                    }
                },
            ],
            'name' => [
                'attribute' => 'name',
                'value' => function($model) {
                    return $model->name . ' ('.\Yii::$app->translate->get($model->name).')';
                },
            ],
            'version',
            [
                'header' => \Yii::$app->translate->get('acms_installation_process'),
                'format' => 'raw',
                'value' => function($model) {
                    
                    switch ($model->isInstallStatus) {
                        case 1:
                            return Html::a(\Yii::$app->translate->get('acms_is_installed'), ['/acms/modules', 'action'=>'#'], [
                                'class' => 'btn btn-default disabled'
                            ]);
                            break;
                        case 2:
                            return Html::a(\Yii::$app->translate->get('acms_is_reinstalled'), ['/acms/modules', 'action'=>\app\modules\acms\controllers\ModulesController::ACTION_REINSTALL, 'folder' => $model->folder], [
                                'class' => 'btn btn-primary'
                            ]);
                            break;
                        default :
                            return Html::a(\Yii::$app->translate->get('acms_to_install'), ['/acms/modules', 'action'=>\app\modules\acms\controllers\ModulesController::ACTION_INSTALL, 'folder' => $model->folder], [
                                'class' => 'btn btn-success',
                                'data-confirm' => \Yii::$app->translate->get('acms_if_install_module'),
                            ]);
                            break;
                    };
                            
                },
            ],
            [
                'header' => \Yii::$app->translate->get('acms_delete'),
                'format' => 'raw',
                'value' => function($model) {
                    return
                            $model->isInstallStatus
                        ?
                            Html::a(\Yii::$app->translate->get('acms_to_delete'), ['/acms/modules', 'action'=>\app\modules\acms\controllers\ModulesController::ACTION_UINSTALL, 'folder' => $model->folder], [
                                'class' => 'btn btn-warning',
                                'data-confirm' => \Yii::$app->translate->get('acms_if_delete_module'),
                            ])
                        :
                            ($model->status == \app\modules\acms\models\Modules::STATUS_NOT_INSTALL ?
                                Html::a(\Yii::$app->translate->get('acms_to_delete_by_filesystem'), ['/acms/modules', 'action'=>\app\modules\acms\controllers\ModulesController::ACTION_FILEDELETE, 'folder' => $model->folder], [
                                    'class' => 'btn btn-danger',
                                    'data-confirm' => \Yii::$app->translate->get('acms_if_delete_by_filesystem_module'),
                                ])
                            :
                                Html::a(\Yii::$app->translate->get('acms_to_delete_by_filesystem'), ['/acms/modules', 'action'=>'#'], [
                                    'class' => 'btn btn-default disabled'
                                ])
                            );
                },
            ],
        ],
    ]); ?>

</div>