<?php if($success = \Yii::$app->session->get('success')): ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><?= \Yii::$app->translate->get('acms_success') ?></h3>
        </div>
        <div class="panel-body"> <?=$success?> </div>
    </div>
<?php endif; ?>
<?php if($error = \Yii::$app->session->get('error')): ?>
    <div class="panel panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title"><?= \Yii::$app->translate->get('acms_error') ?></h3>
        </div>
        <div class="panel-body"> <?=$error?> </div>
    </div>
<?php endif; ?>