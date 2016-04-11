<?php

use yii\helpers\Html;
use app\modules\acms\models\LinkContents;

/* @var $this yii\web\View */
/* @var $model \app\modules\acms\models\TextBlockImages */
?>

<div class="row" style="margin-top: 30px;">
    <div class="col-lg-3 text-right">
        <span><?= \Yii::$app->translate->get('acms_size') ?> <?= $model->name ?></span>
    </div>
    <div class="col-lg-9">
        <div>
            <a href="#" class="thumbnail">            
                <?= Html::img($model->img, [
                    'style' => 'max-width: 150px;',
                    'id' => 'img_' . $model->id,
                ]) ?>
            </a>
        </div>
        
        <div>
            <?= Html::hiddenInput($model->getInputName('clear'), 0, [
                'id' => 'delete_' . $model->id,
            ]) ?>
            
            <?php if(!empty($model->image)): ?>
                <?= Html::button(\Yii::$app->translate->get('acms_to_delete'), [
                    'class' => 'btn btn-danger',
                    'onclick' => new yii\web\JsExpression(' $(\'#delete_'.$model->id.'\').val(1); '
                            . ' $(\'#img_'.$model->id.'\').attr(\'src\', \''.LinkContents::NO_PHOTO.'\'); '
                            . ' $(this).remove(); '),
                ]) ?>
            <?php endif; ?>
        </div>
        
        <div style="margin-top: 20px;">
            <?= Html::fileInput($model->getInputName('imageFile')) ?>
        </div>
        
        <div style="margin-top: 20px;">
            <?= Html::dropDownList($model->getInputName('align'), 
                    $model->align,
                    yii\helpers\ArrayHelper::merge([
                        '' => \Yii::$app->translate->get('acms_align')
                    ], \Yii::$app->params['aligns']), [
                        'class' => 'form-control'
                    ]) ?>
        </div>
    </div>
    
</div>