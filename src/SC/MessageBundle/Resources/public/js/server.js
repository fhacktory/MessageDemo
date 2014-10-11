window.server = Clank.connect(window.WEBSOCKET_SERVER_URI);

window.server.on('socket/connect', function(session){
    console.log('Connected with session', session);
});

window.server.on('socket/disconnect', function(error){
    console.log('Disconnected for', error.reason, 'with code ', error.code);
});
