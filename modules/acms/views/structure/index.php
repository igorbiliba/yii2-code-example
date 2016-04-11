<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Links';
$this->params['breadcrumbs'][] = $this->title;

\app\modules\acms\assets\assetBundles\TreesAsset::register($this);
?>

<?= $this->render('_ctx_menu'); ?>

<div class="links-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div>
        <?= Html::a(\Yii::$app->translate->get('acms_settings_menu_layout'), ['/acms/settings/layout'], [
            'class' => 'btn btn-success',
        ]) ?>
    </div>
    
    <div class="row">
        <?=$tree?>
    </div>

    <hr />
    <div id="template_content" class="row" style="border: 1px solid black;">
        <?php $this->registerJs('window.struct_page.setId('.$id.'); window.struct_page.loadPage(); '); ?>
    </div>
    <hr />
    
    <div class="panel-group">
        <?=$mainPage?>
    </div>
</div>