var mosca = require('mosca');
var CONSTANT = require('../broker/Constant');
var { splitInforRecevie, getCoordinates } = require('../broker/MainHandle');

//STORE DATA FOR EACH ESP
var listEspA = [];
var listEspB = [];
var listEspC = [];

//SET SERVER
var settings = {
    port: 1883
}

var server = new mosca.Server(settings);

server.on('clientConnected', function (client) {
    console.log('client connected : ', client.id);
});

server.on('published', function (packet, client) {
    
   var a =  splitInforRecevie(packet.payload);
    
    if (packet.topic === CONSTANT.TOPIC ) {
        
       // var beaconInfor = splitInforRecevie(packet.payload);

        // filter message 
        // switch (beaconInfor[0]) {
        //     case CONSTANT.ESPID[0]: //DEVICE 1
        //         listEspA.push(beaconInfor);
        //         break;
        //     case CONSTANT.ESPID[1]: //DEVICE 2
        //         listEspB.push(beaconInfor);
        //         break;
        //     case CONSTANT.ESPID[2]: //DEVICE 3
        //         listEspC.push(beaconInfor);
        //         break;
        // }

        if (listEspA[0] !== undefined && listEspB[0] !== undefined && listEspA[0] !== undefined) {
            var arr = [listEspA.length, listEspB.length, listEspC.length];
            var max = Math.max(...arr);
            var minPos = arr.indexOf(Math.min(...arr));
            var macBeacon;
            switch (minPos) {
                case 0: //DEVICE 1
                    macBeacon = listEspA[1];
                    break;
                case 1: //DEVICE 2
                    macBeacon = listEspB[1];
                    break;
                case 2: //DEVICE 3
                    macBeacon = listEspC[1];
                    break;
            }

            var coordinate = getCoordinates(listEspA[0], listEspB[0], listEspC[0]);
            var message = 'Distance|' + 'BE123:' + coordinate[0] + ':' + coordinate[1];
            // mqtt.publish("presence", message);
        }
    }
});

server.on('ready', function () {
    console.log("ready!!!!");
});
