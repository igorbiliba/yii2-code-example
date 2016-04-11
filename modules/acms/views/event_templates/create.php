<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PostEventsTemplates */

$this->title = 'Create Post Events Templates';
$this->params['breadcrumbs'][] = ['label' => 'Post Events Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-events-templates-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
