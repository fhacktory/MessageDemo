$(function() {
    $('#contacts-tab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
});