<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                <?= \Yii::$app->translate->get('acms_full_settings') ?></a>
        </h4>
    </div>
    <div id="collapse2" class="panel-collapse collapse in">
        <div class="panel-body">
            <?php \yii\widgets\Pjax::begin(['id' => 'update_link_setting_pjax']) ?>
            <?php $form = ActiveForm::begin([
                'action' => [
                    'structure/update_link_setting',
                    'id' => $model->id,
                ],
                'id' => 'update_link_setting',
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
                'options' => ['data-pjax' => true]
            ]); ?>

            <div class="col-lg-12">
                <label class="label label-info"><?=$model->url?></label>
            </div>

            <div class="col-lg-12">
                <hr />
            </div>
            
            <div class="col-lg-12">
                <?= $form->field($model, 'is_serch')->checkbox() ?>
            </div>
            
            <div class="col-lg-12">
                <?= $form->field($model, 'show_in_menu')->checkbox() ?>
            </div>

            <div class="col-lg-12">
                <?= $form->field($model, 'show_in_breadcrumbs')->checkbox(['maxlength' => true]) ?>
            </div>

            <div class="col-lg-12">
                <?= $form->field($model, 'layout')->dropDownList(\app\models\DymanicTemplates::getListTemplates(
                        \app\models\DymanicTemplates::FOLDER_DYNAMIC_LAYOUTS
                )) ?>
            </div>
            
            <div class="col-lg-12">
                <?= $form->field($model, 'template')->dropDownList(\app\models\DymanicTemplates::getListTemplates()) ?>
            </div>

            <div class="col-lg-12">
                <?= $form->field($model, 'redirect_link')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-lg-12">
                <?= $form->field($model, 'action')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-lg-12" style="margin-top: 24px;">
                <?= Html::submitButton($model->isNewRecord ?
                    \Yii::$app->translate->get('acms_add') :
                    \Yii::$app->translate->get('acms_edit'), ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
            <?php \yii\widgets\Pjax::end() ?>
        </div>
    </div>
</div>

<?php 
    /**
     * запросим новый шаблон после сохранений параметров
     */
    $this->registerJs(
       '
            $("#update_link_setting_pjax").on("pjax:end", function() {
                window.struct_page.loadPage();
            });
        ', \yii\web\View::POS_READY
    );
?>