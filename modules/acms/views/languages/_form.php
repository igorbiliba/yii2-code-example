<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Languages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="languages-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-lg-4">
        <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-lg-4">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-lg-4" style="margin-top: 24px;">
        <?= Html::submitButton($model->isNewRecord ?
            \Yii::$app->translate->get('acms_add'):
            \Yii::$app->translate->get('acms_edit'),
            ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
