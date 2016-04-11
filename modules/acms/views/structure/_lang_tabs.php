<?php foreach($link->getLinkLanguagesAll() as $languageLink): ?>
    <?php /* @var \app\models\LinkLanguages $languageLink */ ?>
    <?php $language = $languageLink->language; ?>
    <?php /* @var \app\models\Languages $language */ ?>
    <li role="presentation" class="<?= $language->is_default ? 'active' : '' ?>">
        <a
            onclick="
                window.treeObj.loadLanquageSettings(<?= $link->id ?>, <?= $language->id ?>);
                $('li[role=presentation].active').removeClass('active');
                $(this).parent().addClass('active');
                return false;"
            href="#"
            data-link-id="<?= $link->id ?>"
            data-lang-id="<?= $language->id ?>"
        ><?= $language->name ?></a></li>
<?php endforeach; ?>