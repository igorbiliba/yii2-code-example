<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\acms\models\TextBlockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Text Blocks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="text-block-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(
                $searchModel->type == \app\modules\acms\models\TextBlock::TYPE_TEXT_PAGE
                ?
                \Yii::$app->translate->get('acms_add_text_page')
                :
                \Yii::$app->translate->get('acms_add_content_block')
                , ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'is_active' => [
                'attribute' => 'is_active',
                'filter' => [
                    1 => \Yii::$app->translate->get('acms_yes'),
                    0 => \Yii::$app->translate->get('acms_no'),
                ],
                'value' => function($data) {
                    return ($data->is_active) ?
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
                    'style' => 'width: 120px;',
                ],
            ],            
            'created_at:datetime',

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
