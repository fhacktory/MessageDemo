$(function() {
    var body = $('body');
    body.on('click', '.popup .close', function() {
        var id = $(this).attr('data-popup-id');
        $('#'+id).remove();
    });
    body.on('click', '.popup .panel-heading', function() {
        var id = $(this).find('.close').attr('data-popup-id');
        var element = $('#'+id);

        if(element.hasClass('down')) {
            element.animate({top:'0px'});
            element.removeClass('down');
        }
        else {
            element.animate({top:'242px'});
            element.addClass('down');
        }

    });
});