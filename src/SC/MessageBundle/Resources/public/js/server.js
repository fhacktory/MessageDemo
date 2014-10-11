window.server = Clank.connect(window.WEBSOCKET_SERVER_URI);
window.connected = false;
window.session = null;

window.server.on('socket/connect', function(session){
    window.connected = true;
    window.session = session;
});

window.server.on('socket/disconnect', function(error){
    console.log('Disconnected for', error.reason, 'with code ', error.code);
    window.connected = false;
    window.session = null;
});
