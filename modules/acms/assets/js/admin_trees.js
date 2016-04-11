/**
 * класс, помогающий работать с деревьями
 *
 * структура страницы!
 */
var tree = function() {
    this.id = null;

    /**
     * загружаем страницу
     * делаем сабмиты на формах для перезагрузки свежих данных
     */
    this.loadPage = function() {
        var self = this;

        window.struct_page.setId(this.id);
        window.struct_page.loadPage();

        this.loadTabs();

        $.pjax({
            type       : 'GET',
            url        : '/acms/structure/update_credentials?id='+this.id,
            container  : '#update_page_access_pjax',
            data       : {},
            push       : true,
            replace    : false,
            timeout    : 10000,
            "scrollTo" : false
        }).success(function(data) {
            self.recalcCredentails();

            $.pjax({
                type       : 'GET',
                url        : '/acms/structure/update_link_setting?id='+self.id,
                container  : '#update_link_setting_pjax',
                data       : {},
                push       : true,
                replace    : false,
                timeout    : 10000,
                "scrollTo" : false
            }).success(function(data) {
                self.loadLanquageSettings(self.id, null);
            });
        });
    };

    /**
     * вешаем слушателя на клик по ветке дерева
     * и остальные действия
     */
    this.init = function() {
        var self = this;
        $('.gtreetable').on('click', '.node[data-id]', function() {
            var _id = $(this).attr('data-id');

            if(self.id !== _id) {
                self.id = _id;
                self.loadPage();
            }
        });

        //пересчитываем значение для ролей по клику на dropdownlist
        self.recalcCredentails();
        $('body').on('click', '.roles_dd-list', function() {
            self.recalcCredentails();
        });
    };

    /**
     * загружает табуляции языка
     * при клике на раздел
     */
    this.loadTabs = function() {
        var url = '/acms/structure/load_lang_tabs?id='+this.id;
        $.ajax(url).success(function(data) {
            $('#admin-lang-tabs').html(data);
        });
    };

    /**
     * пересчитываем значение для ролей
     *
     */
    this.recalcCredentails = function() {
        var val = [];

        $('.roles_dd-list').each(function() {
            val.push({
                credential_id: $(this).attr('credential-id'),
                val: $(this).val()
            });
        });

        $('#linkcredentialsform-roles').val(JSON.stringify(val));
    };

    /**
     * загрузить форму языковых настроек страницы по выбраномму языку
     *
     * @param id_lang
     */
    this.loadLanquageSettings = function(link_id, id_lang) {
        var url = '/acms/structure/update_language_settings?id='+link_id+'&id_lang='+id_lang;
        $.pjax({
            type       : 'GET',
            url        : url,
            container  : '#update_language_settings_pjax',
            data       : {},
            push       : true,
            replace    : false,
            timeout    : 10000,
            "scrollTo" : false
        });
    };
};

jQuery(document).ready(function () {
    window.treeObj = new tree();
    window.treeObj.init();
});