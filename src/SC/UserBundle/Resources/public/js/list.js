$(document).ready(function(){
    $('.user').click(function(){
        if(!window.connected){
            return false;
        }

        var button = $(this);
        var icon = button.find('i:first');

        icon.attr('class', 'fa fa-refresh fa-spin');

        window.session.call('contact/toggle', {
            id: button.attr('data-user-id'),
            isContact: button.attr('data-is-contact')
        }).then(function(){
            button.attr('data-is-contact', (button.attr('data-is-contact') == 1) ? 0 : 1);

            if(button.attr('data-is-contact') == 1){
                icon.attr('class', 'fa fa-minus');
            } else {
                icon.attr('class', 'fa fa-plus');
            }
        }, function(error, desc){
            console.log('RPC Error', error, desc);

            if(button.attr('data-is-contact') == 1){
                icon.attr('class', 'fa fa-minus');
            } else {
                icon.attr('class', 'fa fa-plus');
            }
        });
    });
});
