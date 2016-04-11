<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Post Events Templates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-events-templates-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(\Yii::$app->translate->get('acms_create_post_events_templates'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'type_event' => [
                'attribute' => 'type_event',
                'value' => function($data) {
                    return $data->name;
                },
                'format' => 'raw',
            ],
            'subject',
            'from_email' => [
                'attribute' => 'from_email',
                'value' => function($data){
                    return $data->getFromEmail();
                },
            ],
            'from_name',
            'content_type' => [
                'attribute' => 'content_type',
                'filter' => \app\models\PostEventsTemplates::$contentTypes,
            ],
            'is_active' => [
                'filter' => [
                    1 => \Yii::$app->translate->get('is_active'),
                    0 => \Yii::$app->translate->get('is_not_active'),
                ],
                'attribute' => 'is_active',
                'value' => function($data) {
                    return ($data->is_active) ? 
                    \yii\bootstrap\Html::label(\Yii::$app->translate->get('is_active'), null, [
                        'class' => 'label label-success'
                    ]) :
                        \yii\bootstrap\Html::label(\Yii::$app->translate->get('is_not_active'), null, [
                        'class' => 'label label-danger'
                    ]);
                },
                'format' => 'raw',
            ],            
            'delay' => [
                'attribute' => 'delay',
                'filter' => [
                    0 => \Yii::$app->translate->get('acms_no_delay'),
                    120 => \Yii::$app->translate->get('acms_n_min_delay', [
                        '{n}' => 2,
                    ]),
                ],
                'value' => function($data) {
                    return ($data->delay < 1) ? 
                    \yii\bootstrap\Html::label(\Yii::$app->translate->get('now_send_post'), null, [
                        'class' => 'label label-success'
                    ]) :
                        \yii\bootstrap\Html::label(\Yii::$app->translate->get('delay_n_before_send', [
                            '{n}' => $data->delay
                        ]), null, [
                        'class' => 'label label-danger'
                    ]);
                },
                'format' => 'raw',
            ],            
            //'from_email:email',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'options' => [
                    'style' => 'width: 53px;'
                ],
            ],
        ],
    ]); ?>

</div>
