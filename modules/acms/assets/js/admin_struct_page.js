var admin_struct_page = function () {
    //доступ к текущему классу внутри каллбеков
    var self = this;

    /**
     * 0-значит страница корневая
     *
     * @type {number}
     */
    this.id = 0;

    //данные по переменной, с которой работаем сейчас
    this.data_variable = null;
    this.data_link_id = null;
    this.data_is_array = null;
    this.data_sort = null;
    //***********************************************

    /**
     * инициализация модуля
     *
     */
    this.init = function () {
        //вешаем событие для перезагрузки контентных блоков после
        //закрытия редактирования блока.
        $('#edit-content-modal').on('hidden.bs.modal', function (e) {

        });

        //если нажали на переменную запишем данные по ней в класс
        $('body').on('mousedown', '.acms_var_template', function () {
            self.data_variable = $(this).attr('data-variable');
            self.data_link_id = $(this).attr('data-link-id');
            self.data_is_array = $(this).attr('data-is-array');
            self.data_sort = $(this).attr('data-sort');
        });

        $('body').on('click', 'a[href="#text"]', this.menuText);
        $('body').on('click', 'a[href="#widget"]', this.menuWidget);
        $('body').on('click', 'a[href="#clear_block"]', this.menuClear);
    };

    /**
     * инициализируем данные модального окна
     * запускам модальное окно
     * 
     * @returns {undefined}
     */
    this.loadModal = function () {
        window.modal_work_varibles.init(self);
        window.modal_work_varibles.show();
    };

    this.menuText = function () {

    };

    this.menuWidget = function () {
        self.loadModal();
    };

    /**
     * очистим переменную
     * и загрузим новый шаблон
     * 
     * @returns {undefined}
     */
    this.menuClear = function () {
        var params = 'variable=' + self.data_variable + '&link_id=' + self.data_link_id + '&is_array=' + self.data_is_array + '&sort=' + self.data_sort;
        $.ajax("/acms/structure/clear_variable?" + params).success(function (data) {
            self.loadPage();
        });
    };

    /**
     * устанавливаем ид страницы
     *
     * @param link_id
     */
    this.setId = function (link_id) {
        this.id = link_id;
    };

    /**
     * загружаем страницу структуры
     * 
     * @returns {undefined}
     */
    this.loadPage = function () {
        $.ajax("/acms/structure/template?id=" + this.id).success(function (data) {
            $("#template_content").html(data);

            //добавим контекстное меню на элементы переменных
            window.registerCtx();
        });
    }
};

$(document).ready(function () {
    window.struct_page = new admin_struct_page();
    window.struct_page.init();
});