<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $models \app\modules\acms\models\LinkSettings */
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                <?= \Yii::$app->translate->get('acms_language_settings') ?></a>
        </h4>
    </div>
    <div id="collapse4" class="panel-collapse collapse">
        <div class="panel-body">

            <ul class="nav nav-tabs" id="admin-lang-tabs">
                <?=$this->render('_lang_tabs', [
                    'link' => $link,
                ])?>
            </ul>
            <div id="languageSettings">
                <?php \yii\widgets\Pjax::begin(['id' => 'update_language_settings_pjax']) ?>
                <?php $form = \yii\bootstrap\ActiveForm::begin([
                    'action' => [
                        'structure/update_language_settings',
                        'id' => $link->id,
                        'id_lang' => $id_lang,
                    ],
                    'id' => 'update_language_settings',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'options' => ['data-pjax' => true]
                ]); ?>

                <?= $form->field($settings, 'title')->textInput(['maxlength' => true]) ?>
                <?= $form->field($settings, 'h1')->textInput(['maxlength' => true]) ?>
                <?= $form->field($settings, 'description')->textarea(['maxlength' => true]) ?>
                <?= $form->field($settings, 'head_tags')->textInput(['maxlength' => true]) ?>
                <?= $form->field($settings, 'canonical_link')->textInput(['maxlength' => true]) ?>

                <div class="col-lg-12" style="margin-top: 24px;">
                    <?= \yii\bootstrap\Html::submitButton(\Yii::$app->translate->get('acms_edit'), ['class' => 'btn btn-success']) ?>
                </div>

                <?php \yii\bootstrap\ActiveForm::end(); ?>
                <?php \yii\widgets\Pjax::end() ?>
            </div>
        </div>
    </div>
</div>