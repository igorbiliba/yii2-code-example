<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Widgets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widgets-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'module_id' => [
                'attribute' => 'module_id',
                'value' => function($model) {
                    $module = $model->module;
                    return $module->name . ' ('.\Yii::$app->translate->get($module->name).')';
                },
            ],
            'name' => [
                'attribute' => 'name',
                'value' => function($model) {
                    return $model->name . ' ('.\Yii::$app->translate->get($model->name).')';
                },
            ],
            'version',
            'created_at',
            // 'updated_at',
            // 'path',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>