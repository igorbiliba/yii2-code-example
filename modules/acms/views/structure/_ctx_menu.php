<?php

use kartik\cmenu\ContextMenu;

$items = [
    ['label' => \Yii::$app->translate->get('acms_text'), 'url' => '#text'],
    ['label' => \Yii::$app->translate->get('acms_widget'), 'url' => '#widget'],
    '<li class="divider"></li>',
    ['label' => \Yii::$app->translate->get('acms_clear_block'), 'url' => '#clear_block', 'class' => 'ert'],
];

// Basic context menu usage on a specific text within a paragaph.
\app\modules\acms\components\widgets\acms_ctx_menu\Widget::begin(['items' => $items]);
\app\modules\acms\components\widgets\acms_ctx_menu\Widget::end();

/* @var $this \yii\web\View */
?>

<div id="varible-edit-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">&nbsp;</h4>
            </div>
            <div class="modal-body" id="varible-edit-modal-content">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= \Yii::$app->translate->get('acms_close') ?></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->