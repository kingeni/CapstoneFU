var mosca = require('mosca');
var { createNewEquations , gauss, contHexToString } = require('../broker/MainHandle');
var _constOr = require('../broker/Constant');
var settings = {
    port: 1883
}

var server = new mosca.Server(settings);
server.on('clientConnected',  (client)=> {
    console.log('client connected : ', client.id);
});

server.on('published',  (packet, client)=> {
    if (packet.topic === myTopic) {
        console.log(contHexToString(packet.payload));
    }
});

server.on('ready',  ()=> {
    console.log("ready!!!!");
});

