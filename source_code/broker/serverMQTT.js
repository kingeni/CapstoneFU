// var mosca = require('mosca');
// var { contHexToString, getCoordinates } = require('../broker/MainHandle');
// var CONSTANT = require('../broker/Constant');

// //var client = mqtt.connect('mqtt://broker.mqttdashboard.com');

// var listBeacon = [];

// // client.on('connect', function () {
    
// // });

// var settings = {
//     port: 1883
  
// }

// var server = new mosca.Server(settings);

// server.on('clientConnected', (client) => {
//     console.log('client connected : ', client.id);
// });

// server.on('published', (packet, client) => {
//     console.log(packet.topic);
//     // if (packet.topic === CONSTANT.TOPIC) {
//     //     var beaconInfor = contHexToString(packet.payload);
//     //     listBeacon.push(beaconInfor);

//     //     if (listBeacon.length === 3) {
//     //         var coordinate = getCoordinates(listBeacon[0][1],listBeacon[1][1], listBeacon[2][1] );
//     //         var message = 'Distance|'+'BE123:'+coordinate[0]+':'+coordinate[1];
//     //         mqtt.publish("presence", message);
//     //     }

//  //   }
// });

// server.on('ready', () => {
//     console.log("ready!!!!");
// });

