<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TextBlock */

$this->title = 'Create Text Block';
$this->params['breadcrumbs'][] = ['label' => 'Text Blocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="text-block-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
