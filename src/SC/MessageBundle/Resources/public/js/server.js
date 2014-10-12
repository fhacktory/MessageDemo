window.server = Clank.connect(window.WEBSOCKET_SERVER_URI);
window.connected = false;
window.session = null;

window.server.on('socket/connect', function(session){
    window.connected = true;
    window.session = session;

    session.subscribe('user/connection', function(uri, parameters){
        console.log(parameters.id, 'is', (parameters.online) ? 'online' : 'offline');
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
});

window.server.on('socket/disconnect', function(error){
    console.log('Disconnected for', error.reason, 'with code ', error.code);
    window.connected = false;
    window.session = null;
});

window.onbeforeunload = function(){
    window.session.unsubscribe('user/connection');
};
