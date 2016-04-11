<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\acms\models\LayoutSettings */

$this->title = 'Update Layout Settings: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Layout Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="layout-settings-update">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
