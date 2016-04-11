<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */

$this->title = 'Update Menu: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

\app\modules\acms\assets\assetBundles\MenuAsset::register($this);
?>
<div class="menu-update">

    <h1><?= \Yii::$app->translate->get('acms_menu') ?></h1>

    <!--<ul class="nav nav-tabs">
        <li role="presentation" class="<?= ($lang == 0) ? 'active' : '' ?>">
            <?= \yii\bootstrap\Html::a($model->defaultMenuLanguage->language->name, [
                'update', 'id' => $model->id,
            ]) ?>
        </li>
        <?php foreach($translates as $translate): ?>
            <li role="presentation" class="<?= ($lang == $translate->language->id) ? 'active' : '' ?>">
                <?= \yii\bootstrap\Html::a($translate->language->name, [
                    'update', 'id' => $model->id, 'lang' => $translate->language->id,
            ]) ?>
            </li>
        <?php endforeach; ?>
    </ul><br />-->
    
    <?= $this->render( ($lang == 0) ? '_form' : '_form_translate', [
        'model' => ($lang == 0) ? $model : $translateLang,
    ]) ?>

    <hr />
    
    <p>
        Чтобы добавить новый пункт меню, просто кликните на любой раздел со структуры сайта.
    </p>
    
    <div class="row">
        <div class="col-lg-6">
            <h3><?= \Yii::$app->translate->get('acms_struckt_site') ?></h3>
            <div>
                <?= $this->render('@gilek/gtreetable/views/widget', ['options'=>[
                // 'manyroots' => true
                //'draggable' => true
            ]]); ?>
            </div>
        </div>
        <div class="col-lg-6">
            <h3><?= \Yii::$app->translate->get('acms_struckt_menu') ?></h3>
        </div>
    </div>
</div>

<?php $this->registerCss('
    .gtreetable .dropdown-toggle {
        display: none;
    }
    
    .gtreetable .icon {
        display: none;
    }
    
    .gtreetable span > .node-icon-selected.icon {
        display: none;
    }
    
    .gtreetable tr[data-id] {
        cursor: pointer;
    }
'); ?>

<?php $this->registerJs('
    $(".gtreetable").on("click", "tr[data-id]", function() {
        var id = $(this).attr("data-id");
        //добавляем в структуру меню
    });
'); ?>