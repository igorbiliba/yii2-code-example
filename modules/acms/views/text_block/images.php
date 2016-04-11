<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TextBlock */

$this->title = 'images';
$this->params['breadcrumbs'][] = ['label' => 'Text Blocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'images';
?>
<div class="text-block-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_tabs', [
        'model' => $model,
        'lang_id' => null,
        'isImages' => true,
    ]) ?>
    
    <div class="row" style="margin-top: 20px;">
        <?= \app\modules\acms\components\widgets\image_settings_button\Widget::widget([
            'size_id' => \app\modules\acms\models\TextBlock::$CurrentSizeId
        ]) ?>
    </div>
    
    <?= Html::beginForm(['images', 'id' => $model->id], 'POST', ['enctype' => 'multipart/form-data']) ?>
        <?php foreach ($model->images as $image): ?>
            <?= $this->render('_adapty_img', [
                'model' => $image,
            ]) ?>
        <?php endforeach; ?>
    
    <div class="text-right" style="margin-top: 30px;">
            <?= Html::submitButton(\Yii::$app->translate->get('acms_save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?= Html::endForm() ?>

</div>
