<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\TextBlock */
/* @var $form yii\widgets\ActiveForm */

\dosamigos\ckeditor\CKEditorWidgetAsset::register($this);
?>

<div class="text-block-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    
    <?= $form->field($model, 'is_active')->checkbox() ?>

    <?= $form->field($model, 'title')->textInput() ?>
    
    <!--
    <?= $form->field($model, 'type')->dropDownList([ 'content_block' => 'Content block', 'text_page' => 'Text page', ], ['prompt' => '']) ?>
    -->

    <div>
        <a href="#" class="thumbnail">
            <?= Html::img($model->img, [
                'style' => 'max-width: 150px;',
                'id' => 'img',
            ]) ?>
        </a>
    
        <?= $form->field($model, 'clear')->hiddenInput(['id' => 'delete'])->label(false) ?>
        
        <?php if(!empty($model->image)): ?>
            <?= Html::button(\Yii::$app->translate->get('acms_to_delete'), [
                'class' => 'btn btn-danger',
                'onclick' => new yii\web\JsExpression(' $(\'#delete\').val(1); '
                        . ' $(\'#img\').attr(\'src\', \''.  \app\modules\acms\models\LinkContents::NO_PHOTO.'\'); '
                        . ' $(this).remove(); '),
            ]) ?>
        <?php endif; ?>
    </div>
    
    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <?= $form->field($model, 'is_use_editor')->checkbox() ?>
    
    <?= $form->field($model, 'text')->textarea() ?>
    
    <?php if($model->is_use_editor): ?>
        <?php $this->registerJs("$('#textblock-text').ckeditor();") ?>
    <?php endif; ?>

    <?php if($model->type != \app\modules\acms\models\TextBlock::TYPE_TEXT_PAGE): ?>
        <?= $form->field($model, 'js')->textarea(['rows' => 6]) ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 
                \Yii::$app->translate->get('create')
                :
                \Yii::$app->translate->get('update')
                , ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$this->registerJs("$('#textblock-is_use_editor').change(function(){
		toogleEditor($(this).is(':checked'));
	})                                                                 

	function toogleEditor(val) {
		if (!val){
                    CKEDITOR.instances['textblock-text'].destroy();
		} else {	
                    $('#textblock-text').ckeditor();	
		}
	}
");

?>