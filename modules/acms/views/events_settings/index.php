<?php
/* @var $this yii\web\View */
?>

<ul class="nav nav-tabs" role="tablist">
    <?php foreach ($languages as $language): ?>        
        <li role="presentation" class="<?= ($language_id == $language->id) ? 'active' : '' ?>">
            <?= \yii\bootstrap\Html::a($language->name, ['index', 'language_id' => $language->id]) ?>
        </li>    
    <?php endforeach; ?>    
</ul>

<?= $this->render('_form', [
        'model' => $model,
    ]) ?>