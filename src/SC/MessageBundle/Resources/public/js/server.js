window.server = Clank.connect(window.WEBSOCKET_SERVER_URI);
window.connected = false;
window.session = null;

function getDiscussionId(id) {
    return (parseInt(window.USER_ID) < parseInt(id))
        ? window.USER_ID + '-' + id
        : id + '-' + window.USER_ID;
}

window.server.on('socket/connect', function(session){
    window.connected = true;
    window.session = session;

    session.subscribe('user/connection', function(uri, parameters){
        $('[data-contact-id="' + parameters.id + '"]').each(function(){
            if(parameters.online){
                $(this)
                    .removeClass('offline')
                    .removeClass('disabled')
                    .addClass('online');

                $(this).find('p.contact-status-info span').text('En ligne');
            } else {
                $(this)
                    .removeClass('online')
                    .addClass('offline')
                    .addClass('disabled');

                $(this).find('p.contact-status-info span').text('Hors ligne');
            }
        });
    });

    var contacts = [];
    $('[data-contact-id]').each(function(){
        var id = $(this).attr('data-contact-id');
        if($.inArray(id, contacts) === -1){
            contacts.push(id);
        }
    });

    $.each(contacts, function(key, id){
        session.subscribe('discussion/' + getDiscussionId(id), function(uri, parameters){
            var message = $(parameters.message);
            var messagesId = null;

            if(parameters.from == window.USER_ID){
                messagesId = parameters.to;
                message
                    .find('.popover:first')
                    .removeClass('right popover-static-rightleft popover-left')
                    .addClass('left popover-static-left');
            } else {
                messagesId = parameters.from;
                message
                    .find('.popover:first')
                    .removeClass('left popover-static-left')
                    .addClass('right popover-static-right');
            }

            $('#contact-' + messagesId + '-messages').append(message);
        });
    });
});

window.server.on('socket/disconnect', function(error){
    console.log('Disconnected for', error.reason, 'with code ', error.code);
    window.connected = false;
    window.session = null;
});

window.onbeforeunload = function(){
    window.session.unsubscribe('user/connection');
};
