<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\acms\models\ImageSizes */

$this->title = 'Update Image Sizes: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Image Sizes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="image-sizes-update">

    <h1><?= Yii::$app->translate->get('acms_adapty_for') ?>: <?= Yii::$app->translate->get($model->key) ?></h1>

    <?= yii\bootstrap\Html::label($model->key, null, [
        'class' => 'label label-info',
    ]) ?>

    <?= $this->render('_form_size', [
        'model' => $modelSize,
    ]) ?>
    
    
    <h2><?= Yii::$app->translate->get('acms_all_sizes') ?></h2>
    <?php $form = ActiveForm::begin(); ?>
    
        <?php foreach($model->sizes as $size): ?>
            <?php /* @var $size app\modules\acms\models\ImageSizesItem */ ?>
            <div class="form-group field-textblocklanguages-title has-success">
                <label class="control-label" for="textblocklanguages-title"><?= Yii::$app->translate->get('acms_name') ?></label>
                <input type="text" value="<?= $size->name ?>" class="form-control" name="<?= $size->getInputName('name') ?>">        
            </div>

            <div class="form-group field-textblocklanguages-title has-success">
                <label class="control-label" for="textblocklanguages-title"><?= Yii::$app->translate->get('acms_width') ?></label>
                <input type="text" value="<?= $size->width ?>" class="form-control" name="<?= $size->getInputName('width') ?>">        
            </div>

            <div class="form-group field-textblocklanguages-title has-success">
                <label class="control-label" for="textblocklanguages-title"><?= Yii::$app->translate->get('acms_height') ?></label>
                <input type="text" value="<?= $size->height ?>" class="form-control" name="<?= $size->getInputName('height') ?>">        
            </div>

            <div class="form-group field-textblocklanguages-title has-success">
                <label class="control-label" for="textblocklanguages-title"><?= Yii::$app->translate->get('acms_min_width') ?></label>
                <input type="text" value="<?= $size->min_width ?>" class="form-control" name="<?= $size->getInputName('min_width') ?>">        
            </div>

            <div>
                <?= Html::a(Yii::$app->translate->get('acms_delete'), [
                    '/acms/images/delete_size', 'id' => $size->id,
                ], [
                    'class' => 'btn btn-danger',
                    'data-confirm' => Yii::$app->translate->get('acms_if_delete_size', [
                        '{name}' => $size->name,
                    ]),
                ]) ?>
            </div>
    
            <hr />
        <?php endforeach; ?>
            
        <div class="row">
            <?= Html::submitButton(Yii::$app->translate->get('acms_edit'), ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
