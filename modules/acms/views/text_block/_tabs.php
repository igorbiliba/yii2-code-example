<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TextBlock */
?>

<ul class="nav nav-tabs">
    <?php foreach ($model->translates as $item): ?>
        <li role="presentation" class="<?= ($isImages) ? : ($item->language->id == $lang_id ? 'active' : '') ?>">
            <?= Html::a($item->language->name, [
                'update', 'id' => $item->text_block_id, 'lang_id' =>  $item->language->id,
            ]) ?>
        </li>
    <?php endforeach; ?>

    <li role="presentation" class="<?= $isImages ? 'active' : '' ?>">
        <?= Html::a(\Yii::$app->translate->get('acms_images_for_adapty'), [
            'images', 'id' => $model->id,
        ]) ?>
    </li>
</ul>