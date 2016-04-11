<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                <?= \Yii::$app->translate->get('acms_settings_access') ?></a>
        </h4>
    </div>
    <div id="collapse1" class="panel-collapse collapse">
        <div class="panel-body">
            <?php \yii\widgets\Pjax::begin(['id' => 'update_page_access_pjax']) ?>
            <?php $form = \yii\bootstrap\ActiveForm::begin([
                'action' => [
                    'structure/update_credentials',
                    'id' => $model->link->id,
                ],
                'id' => 'update_page_access',
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'options' => ['data-pjax' => true]
            ]); ?>

            <?= $form->field($model, 'roles')->hiddenInput() ?>

            <?php foreach($model->link->getAllCredentials() as $credential): ?>
                <?php /* @var \app\models\LinkCredentials $credential */ ?>
                <div class="col-lg-12">
                    <div class="form-group field-linksettings-redirect_link">
                        <label class="control-label" for="#"><?= $credential->role->name ?></label>
                        <?= \yii\bootstrap\Html::dropDownList(
                            'crd-'.$credential->id,
                            $credential->access,
                            \app\modules\acms\models\form\LinkCredentialsForm::getCredentialsParam(),
                            [
                                'class' => 'form-control roles_dd-list',
                                'credential-id' => $credential->id,
                            ]
                        ) ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="col-lg-12" style="margin-top: 24px;">
                <?= \yii\bootstrap\Html::submitButton(\Yii::$app->translate->get('acms_edit'), ['class' => 'btn btn-success']) ?>
            </div>

            <?php \yii\bootstrap\ActiveForm::end(); ?>
            <?php \yii\widgets\Pjax::end() ?>
        </div>
    </div>
</div>