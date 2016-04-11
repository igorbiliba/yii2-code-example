<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ImageSizesItem */
/* @var $form yii\widgets\ActiveForm */
?>

<?php if($success = \Yii::$app->session->get('size_success')): ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><?= \Yii::$app->translate->get('acms_success') ?></h3>
        </div>
        <div class="panel-body"> <?=$success?> </div>
    </div>
<?php endif; ?>
<?php if($error = \Yii::$app->session->get('size_error')): ?>
    <div class="panel panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title"><?= \Yii::$app->translate->get('acms_error') ?></h3>
        </div>
        <div class="panel-body"> <?=$error?> </div>
    </div>
<?php endif; ?>

<div class="image-sizes-item-form">

    <h2><?= Yii::$app->translate->get('acms_add_size') ?></h2>
    
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'width')->textInput() ?>

    <?= $form->field($model, 'height')->textInput() ?>

    <?= $form->field($model, 'min_width')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::$app->translate->get('acms_create'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>