$(function() {
    $('#contacts-tab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });

    $('body').on('click', 'a[data-open="0"]', function(){
        $(this).attr('data-open', '1');
        var page = $(this).attr('data-next-page');
        var id = $(this).attr('href');

        if(page === undefined || !page) {
            page = 1;
        }

        window.session.call('discussion/page', {
            id: $(this).attr('data-contact-id'),
            page: page
        }).then(function(result){
            $(this).attr('data-next-page', page + 1);
            $(id).find('.messages:first').prepend(result);
        }, function(error, desc){
            console.log('RPC Error', error, desc);
        });
    });

    $('.send-message').click(function(e){
        e.preventDefault();
        var textarea = $(this).closest('form').find('textarea:first');
        var content = textarea.val();
        textarea.val('');
    });
});