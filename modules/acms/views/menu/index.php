<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\acms\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <h1><?= \Yii::$app->translate->get('acms_menu') ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(\Yii::$app->translate->get('acms_create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'is_active' => [
                'filter' => [
                    1 => \Yii::$app->translate->get('acms_yes'),
                    0 => \Yii::$app->translate->get('acms_no'),
                ],
                'attribute' => 'is_active',
                'value' => function($data) {
                    return ($data->is_active) ?
                        \yii\bootstrap\Html::label(\Yii::$app->translate->get('acms_yes'), null, [
                            'class' => 'label label-success'
                        ])
                    :
                        \yii\bootstrap\Html::label(\Yii::$app->translate->get('acms_no'), null, [
                            'class' => 'label label-danger'
                        ]);
                },
                'format' => 'raw',
                'options' => [
                    'style' => 'width: 10px;',
                ],
            ],
            'name',
            //'type',            
            //'created_at',
            //'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}  {delete}',
                'options' => [
                    'style' => 'width: 55px;',
                ],
            ],
        ],
    ]); ?>

</div>
