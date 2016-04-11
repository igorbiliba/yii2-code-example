/**
 * Ркгистрация служебный элементов
 */
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});


/**
 * Регистрирует нажатие на кнопку
 * и отсылает данные в get с чекбоксов на указанный экшен
 * 
 * в чекбоксах данные хранятся в data-id
 * 
 * @param {type} button_id "ид дконки действия"
 * @param {type} action    "экшен, куда посылать данные"
 * @param {type} cbx_class "класс чекбоксов, с которых собирать данные"
 * @returns {undefined}
 */
function cbxAction(button_id, action, cbx_select, cb) {
    $('#'+button_id).bind('click', function() {
        var data = [];
        
        $(cbx_select+':checked').each(function() {
            data.push($(this).attr('value'));
        });     
        
        $.ajax(action+'?idx='+data.join(',')).success(cb);
    });
}