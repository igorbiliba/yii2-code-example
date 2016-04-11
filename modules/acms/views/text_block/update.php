<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TextBlock */

$this->title = 'Update Text Block: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Text Blocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="text-block-update">

    

    <?= $this->render('_tabs', [
        'model' => $model,
        'lang_id' => $lang_id,
        'isImages' => false,
    ]) ?>
    
    
    <?php
        if($translate) {
            echo $this->render('_form_lang', [
                'model' => $translate,
            ]);
        }
        else {
            echo $this->render('_form', [
                'model' => $model,
            ]);
        }
    ?>

</div>
