<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Post Events';
$this->params['breadcrumbs'][] = $this->title;

//\Yii::$app->event->push('qweqwe@mail.ru', 'registration', []);

?>
<div class="post-events-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,        
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'options' => [
                    'width' => '10px',
                ],
            ],
            'id',
            //'email:email',
            /*'type_event' => [
                'attribute' => 'type_event',
                'value' => function($data) {
                    return $data->template->name;
                },
            ],*/
            'subject',
            //'from_email',
            //'from_name',
            'status' => [
                'attribute' => 'status',                
                'filter' => \app\modules\acms\models\EventsSearch::getListStatus(),
                'value' => function($data) {
        
                    switch ($data->status) {
                        case app\models\PostEvents::STATUS_IS_SEND:
                            
                            return Html::label(\Yii::$app->translate->get($data->status), null, [
                                'class' => 'label label-success',
                            ]);
                            
                            break;
                        case app\models\PostEvents::STATUS_WAIT:
                            
                            return Html::label(\Yii::$app->translate->get($data->status), null, [
                                'class' => 'label label-warning',
                            ]);
                            
                            break;
                        case app\models\PostEvents::STATUS_TROUBLE:
                            
                            return Html::label(\Yii::$app->translate->get($data->status), null, [
                                'class' => 'label label-danger',
                            ]);
                            
                            break;
                    };
        
                    return \Yii::$app->translate->get($data->status);
                },
                'format' => 'raw',
            ],                        
            'created_at:datetime',
            'expire' => [
                'attribute' => 'expire',
                'value' => function($data) {
                    return \Yii::$app->formatter->asDatetime($data->expire);
                },
            ],
            // 'updated_at',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?= Html::button(\Yii::$app->translate->get('acms_to_delete'), [
        'class' => 'btn btn-danger',
        'id' => 'action-delete',
    ]) ?>
    
    <?php $this->registerJs('cbxAction("action-delete", "/acms/events/delete", "input[type=checkbox]", function() { location.reload(); });'); ?>
    
</div>
