/**
 * Класс работы с модальным окном 
 * добавления / редактирования пременной
 * 
 * @returns {admin_modal_work_varibles}
 */
var admin_modal_work_varibles = function() {    
    //данные переменной, над которой работаем
    this.struct = null;
    
    /**
     * инициализируем данные переменной, над которой работаем
     * 
     * @param admin_struct_page struct
     * @returns {undefined}
     */
    this.init = function(obj) {
        /*
            this.struct.data_variable
            this.struct.data_link_id
            this.struct.data_is_array
            this.struct.data_sort
        */
        this.struct = obj;
    };
    
    this.show = function() {
        $('#varible-edit-modal').modal('show');
        this.loadData();
    };
    
    /**
     * загрузим даненые по этой переменной
     * 
     * @returns {undefined}
     */
    this.loadData = function() {
        var params = 'variable=' + this.struct.data_variable + '&link_id=' + this.struct.data_link_id + '&is_array=' + this.struct.data_is_array + '&sort=' + this.struct.data_sort;
        $.ajax("/acms/structure/get_modal_content?" + params).success(function (data) {
            $('#varible-edit-modal-content').html(data);
        });
    }
};

$(document).ready(function() {
    window.modal_work_varibles = new admin_modal_work_varibles();
});