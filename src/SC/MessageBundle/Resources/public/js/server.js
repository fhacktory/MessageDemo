window.server = Clank.connect(window.WEBSOCKET_SERVER_URI);
window.connected = false;
window.session = null;

window.server.on('socket/connect', function(session){
    window.connected = true;
    window.session = session;

    session.subscribe('user/connection', function(uri, parameters){
        $('.contact-' + parameters.id + '-status-info').each(function(){
            if($(this).hasClass('online')){
                $(this)
                    .removeClass('online')
                    .addClass('offline');
            } else {
                $(this)
                    .removeClass('offline')
                    .addClass('online');
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
