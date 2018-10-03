var mosca = require('mosca');
var { contHexToString, getCoordinates } = require('../broker/MainHandle');
var CONSTANT = require('../broker/Constant');
var mqtt = require('mqtt');
var client = mqtt.connect('mqtt://broker.mqttdashboard.com');

var listBeacon = [];

client.on('connect', function () {
    setInterval(function () {
        client.publish('presence', 'Hello mqtt');
        console.log('Message Sent');
    }, 5000);
});

var settings = {
    port: 1883,
}

var server = new mosca.Server(settings);

server.on('clientConnected', (client) => {
    console.log('client connected : ', client.id);
});

server.on('published', (packet, client) => {
    if (packet.topic === myTopic) {
        var beaconInfor = contHexToString(packet.payload);
        listBeacon.push(beaconInfor);

        if (listBeacon.length === 3) {
            var coordinate = getCoordinates(listBeacon[0][1],listBeacon[1][1], listBeacon[2][1] );
            var message = 'Distance|'+'BE123:'+coordinate[0]+':'+coordinate[1];
            mqtt.publish("presence", message);
        }

    }
});

server.on('ready', () => {
    console.log("ready!!!!");
});

