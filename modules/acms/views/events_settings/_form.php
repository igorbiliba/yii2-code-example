<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostEventsSettings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-events-settings-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'from_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'from_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'header')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'footer')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(\Yii::$app->translate->get('acms_edit'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
