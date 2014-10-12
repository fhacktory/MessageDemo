$(document).ready(function() {
    $('#contacts-tab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });

    scrollToBottom($('.tab-pane.active:first .messages:first'));

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
            var messages = $(id).find('.messages:first');
            messages.prepend(result);
            scrollToBottom(messages);
        });
    });

    $('.send-message').click(function(e){
        e.preventDefault();
        var textarea = $(this).closest('form').find('textarea:first');
        var content = textarea.val();

        window.session.publish('discussion/' + getDiscussionId($(this).attr('data-contact-id')), {
            message: content
        });

        textarea.val('');
    });
});