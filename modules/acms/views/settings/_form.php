<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\render\RenderDynamicTemplate;
use app\modules\acms\models\Menu;
use app\models\DymanicTemplates;

/* @var $this yii\web\View */
/* @var $model app\modules\acms\models\LayoutSettings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="layout-settings-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'layout_path')
            ->dropDownList(
                    \app\models\DymanicTemplates::getListTemplates(\app\models\DymanicTemplates::FOLDER_DYNAMIC_LAYOUTS),
                    [
                        'onchange' => new yii\web\JsExpression('                            
                            window.location = \''. (\yii\helpers\Url::to(['layout', 'id' => ''])) .'\' + $(this).val();
                        '),
                    ]
            ) ?>

    
    <?= \yii\bootstrap\Html::a(\Yii::$app->translate->get('acms_set_layout_default'), [
        '/acms/settings/default_layout', 'id' => $model->id, 'path' => $model->layout_path
    ], [
        'class' => 'btn btn-success' . ($model->is_default ? ' disabled' : ''),
    ]) ?>
    
    <hr />
    
    <p><?= \Yii::$app->translate->get('acms_the_setup_menu') ?>:</p>
    <div>
        <?php foreach($model->getMatches('variables') as $match): ?>
            <?php $name = RenderDynamicTemplate::getName($match); ?>
            <?php $variable = $model->getVariable($name); ?>
        
            <div class="form-group field-layoutsettings-layout">
                <label class="control-label" for="layoutsettings-layout"><?= $name ?></label>
                <div class="row" style="padding-left: 30px;">
                    <label><?= \Yii::$app->translate->get('acms_template') ?></label>                   
                    <?= Html::dropDownList(Html::getInputName($model, $name).'[template]', $variable->menu_template,  DymanicTemplates::getListTemplates(DymanicTemplates::FOLDER_DYNAMIC_MENU, true), [
                        'class' => 'form-control',
                    ]) ?>
                </div>
                <div class="row" style="padding-left: 30px;">
                    <label><?= \Yii::$app->translate->get('acms_select_menu') ?></label>
                    <?= Html::dropDownList(Html::getInputName($model, $name).'[menu]', $variable->menu_id, Menu::getAll(), [
                        'class' => 'form-control',
                    ]) ?>
                </div>
            </div>
        
        <?php endforeach; ?>
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
