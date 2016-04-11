<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PostEventsTemplates */

$this->title = 'Update Post Events Templates: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Post Events Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-events-templates-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'defaultSettings' => $defaultSettings,
    ]) ?>

</div>

<ul class="nav nav-tabs" role="tablist">
    <?php foreach ($languages as $language): ?>        
        <li role="presentation" class="<?= ($language_id == $language->id) ? 'active' : '' ?>">
            <?= \yii\bootstrap\Html::a(
                    $language->name, ['update', 'id' => $model->id, 'language_id' => $language->id]) ?>
        </li>    
    <?php endforeach; ?>    
</ul>
<?= $this->render('_form_language_template', [
    'model' => $templateLang
]) ?>