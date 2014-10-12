$(function() {
    $('body').on('click', '.popup .close', function() {
        var id = $(this).attr('data-popup-id');
        $('#'+id).remove();
    });
});