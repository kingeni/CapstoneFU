<?php
/**
 * Created by PhpStorm.
 * User: Huy Ta
 * Date: 9/17/2018
 * Time: 3:41 PM
 */

namespace console\controllers;

use common\helper\MQTT;
use yii\console\Controller;

class SubscriberController extends Controller
{
    public function actionSubcribe()
    {
        $server = "broker.hivemq.com";     // change if necessary
        $port = 1883;                     // change if necessary
        $username = "";                   // set your username
        $password = "";                   // set your password
        $client_id = "phpMQTT-subscriber"; // make sure this is unique for connecting to sever - you could use uniqid()

        $mqtt = new MQTT($server, $port, $client_id);

        if (!$mqtt->connect(true, NULL, $username, $password)) {
            exit(1);
        }

        $topics['presence'] = array("qos" => 0, "function" => "procmsg");
        $mqtt->subscribe($topics, 0);

        while ($mqtt->proc()) {
        }
        $mqtt->close();

        function procmsg($topic, $msg)
        {
            echo "Msg Recieved: " . date("r") . "\n";
            echo "Topic: {$topic}\n\n";
            echo "\t$msg\n\n";
        }
    }


}