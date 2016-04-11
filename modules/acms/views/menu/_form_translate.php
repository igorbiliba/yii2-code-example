<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">
    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'name')->textInput() ?>
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ?
            \Yii::$app->translate->get('acms_add'):
            \Yii::$app->translate->get('acms_edit'),
            ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
