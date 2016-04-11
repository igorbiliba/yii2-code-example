<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostEventsTemplatesLanguages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-events-templates-languages-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'from_name')->textInput(['maxlength' => true]) ?>

    <p>
        <label><?= \Yii::$app->translate->get('acms_params') ?>:</label>
        <span>
            <?php foreach ($model->variablesTemplate as $item): ?>
            {{<?=$item?>}} &nbsp;
            <?php endforeach; ?>
        </span>
    </p>
    
    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 
                \Yii::$app->translate->get('create')
                :
                \Yii::$app->translate->get('update')
                , ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>