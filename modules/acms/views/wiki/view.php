<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Техническая документация по ACMS: ' . $model->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widgets-index">
    <div>        
        <?= $model->content ?>        
    </div>
</div>
