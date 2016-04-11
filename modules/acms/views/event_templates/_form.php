<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostEventsTemplates */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-events-templates-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>
    
    <div class="row">        
        <div class="col-lg-6">
            <?= $form->field($model, 'type_event')->dropDownList(
                app\models\PostEvents::getListEvents()
            ) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'delay')->dropDownList([
                0 => \Yii::$app->translate->get('acms_no_delay'),
                120 => \Yii::$app->translate->get('acms_n_min_delay', [
                    '{n}' => 2,
                ]),
            ]) ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'content_type')->dropDownList([ 'text/html' => 'Text/html', 'text/plain' => 'Text/plain', ], ['prompt' => '']) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'from_email')->textInput([
                'maxlength' => true,
                'placeholder' => (!empty($defaultSettings)) ? \Yii::$app->translate->get('acms_is_default_email', [
                    '{email}' => $defaultSettings->from_email,
                ]): '',
                ]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 
                \Yii::$app->translate->get('create')
                :
                \Yii::$app->translate->get('update')
                , ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
