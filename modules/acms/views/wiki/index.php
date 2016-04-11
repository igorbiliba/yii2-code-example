<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Техническая документация по ACMS';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widgets-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <ul>
        <?php foreach ($models as $model): ?>
            <li>
                <?= Html::a($model->name, [
                    '/acms/wiki/view', 'id' => $model->name,
                ]) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
