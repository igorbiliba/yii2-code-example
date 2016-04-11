<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                <?= \Yii::$app->translate->get('acms_contents_blocks_pages') ?></a>
        </h4>
    </div>
    <div id="collapse3" class="panel-collapse collapse">
        <div class="panel-body">
            <div id="content_blocks">
                <?= $this->render('_contents_block', [
                    'blocks' => $blocks,
                ]) ?>
            </div>
            <?= $this->render('_content_blocks/_empty.php') ?>
        </div>
    </div>
</div>