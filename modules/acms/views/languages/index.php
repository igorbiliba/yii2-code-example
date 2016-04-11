<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Languages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="languages-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('./../_part/_flash') ?>

    <p>
        <h3><?= \Yii::$app->translate->get('acms_add_language') ?></h3>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </p>

    <div class="row">&nbsp;</div>

    <hr />

    <div class="row">&nbsp;</div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'enable',
                'value' => function($data) {
                    /* @var app\models\Languages $data */
                    return ($data->enable) ?
                        Html::label(\Yii::$app->translate->get('acms_is_active'), null, [
                            'class' => 'label label-success',
                        ])
                        :
                        Html::label(\Yii::$app->translate->get('acms_is_not_active'), null, [
                            'class' => 'label label-danger',
                        ]);
                },
                'format' => 'raw',
                'options' => [
                    'style' => 'width: 20px;',
                ],
            ],
            [
                'header' => \Yii::$app->translate->get('acms_the_activation'),
                'value' => function($data) {
                    return $data->enable ?
                        Html::a(\Yii::$app->translate->get('acms_is_deactivate'),
                            ['index', 'id'=>$data->id, 'is_active' => 0], [
                            'class' => 'btn btn-danger' . ($data->is_default ? ' disabled' : ''),
                        ])
                        :
                        Html::a(\Yii::$app->translate->get('acms_is_activate'), ['index', 'id'=>$data->id, 'is_active' => 1], [
                            'class' => 'btn btn-success',
                        ]);
                },
                'format' => 'raw',
                'options' => [
                    'style' => 'width: 20px;',
                ],
            ],
            'key',
            'title',
            [
                'attribute' => 'is_default',
                'value' => function($data) {
                    return $data->is_default ?
                        Html::a(\Yii::$app->translate->get('acms_selected_by_default'), '#', [
                            'class' => 'btn btn-default disabled',
                        ])
                        :
                        Html::a(\Yii::$app->translate->get('acms_select_by_default'), ['index', 'id'=>$data->id, 'is_default' => 1], [
                            'class' => 'btn btn-success' . ($data->enable ? '' : ' disabled'),
                        ]);
                },
                'format' => 'raw',
                'options' => [
                    'style' => 'width: 20px;',
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'options' => [
                    'style' => 'width: 50px;',
                ],
            ],
        ],
    ]); ?>

</div>
