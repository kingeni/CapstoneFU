

#include <WiFi.h>
#include <dummy.h>
#include <BLEDevice.h>
#include <BLEUtils.h>
#include <BLEScan.h>
#include <BLEAdvertisedDevice.h>
#include <WiFiClient.h>
#include <PubSubClient.h>



<<<<<<< HEAD
const char* ssid = "TIC";      
const char* password = "Agiftfromtheheart";  

const char* mqtt_server = "m15.cloudmqtt.com";       
const int mqtt_port = 14160;
const char *mqtt_user = "ficcvcbx";       
const char *mqtt_pass = "pKXvIjcgN_0B";
const char *mqtt_client_name = "arduinoClient";
const char *mqtt_topic = "/beacon/data";
char msg[50];
int scanTime = 3; //In seconds

=======
const char* ssid = "TMA Lab 9 2.4Ghz";      
const char* password = "12345x@X";  

const char* mqtt_server = "m14.cloudmqtt.com";       
const int mqtt_port = 13316;
const char *mqtt_user = "krvzvfeh";       
const char *mqtt_pass = "DsQv2w7F1gOA";
const char *mqtt_client_name = getDeviceID().c_str();
const char *mqtt_topic = "/beacon/data";
char msg[50];
int scanTime = 3; //In seconds
String DeviceID = getDeviceID();
>>>>>>> origin/mtquan_home

WiFiClient espClient;
PubSubClient client(espClient);

<<<<<<< HEAD
=======
String getDeviceID() {
	String temp;
	uint8_t chipid[6];
	esp_efuse_read_mac(chipid);
	for (int i = 0;i < 6;i++) {
		//Serial.print(chipid[i]);
		temp = temp + chipid[i];
	}
	return temp;
}
>>>>>>> origin/mtquan_home
void setup_wifi()
{
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  Serial.print("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    delay(500);
  }
  Serial.println("");
  Serial.println("Wifi connected!");
}

void reconnect()
{
  while (!client.connected()) {
    if (client.connect(mqtt_client_name, mqtt_user, mqtt_pass)) {
      client.publish(mqtt_topic, "Boot doned!");
    }
    else {
      delay(5000);
    }
  }
}

class MyAdvertisedDeviceCallbacks : public BLEAdvertisedDeviceCallbacks {
  void onResult(BLEAdvertisedDevice advertisedDevice) {
  }
};

void setup() {
  Serial.begin(115200);
  setup_wifi();              
  client.setServer(mqtt_server, mqtt_port);
}

BLEScanResults scanBeacon() {
  Serial.println("Scanning...");
  BLEDevice::init("");
  BLEScan* pBLEScan = BLEDevice::getScan(); //create new scan
  pBLEScan->setAdvertisedDeviceCallbacks(new MyAdvertisedDeviceCallbacks());
  pBLEScan->setActiveScan(true); //active scan uses more power, but get results faster
  BLEScanResults foundDevices = pBLEScan->start(scanTime);
  
  Serial.println("Scan done!");
  return(foundDevices);
}
void publicMsg(BLEScanResults foundDevices) {
  for (int i = 0;i < foundDevices.getCount();i++) {
<<<<<<< HEAD
	  Serial.println();
	  delay(100);
    Serial.print("MAC: "+i);
=======
	Serial.print("DeviceID: " + DeviceID);
	Serial.print(" MAC: " + i);
>>>>>>> origin/mtquan_home
    Serial.print(foundDevices.getDevice(i).getAddress().toString().c_str());
    Serial.print("RSSI:");
    Serial.print(foundDevices.getDevice(i).getRSSI());
    Serial.println();
<<<<<<< HEAD
    snprintf(msg, 100, "%s|%ld",foundDevices.getDevice(i).getAddress().toString().c_str(), foundDevices.getDevice(i).getRSSI());
=======
    snprintf(msg, 100, "%s|%s|%ld",DeviceID.c_str(),foundDevices.getDevice(i).getAddress().toString().c_str(), foundDevices.getDevice(i).getRSSI());
>>>>>>> origin/mtquan_home
    client.publish(mqtt_topic, msg);
  }
  Serial.println("Public data done!");
  //delay(1000);
}

void loop() {
  if (!client.connected()) {
    reconnect();
  }
  client.loop();
  BLEScanResults result = scanBeacon();
  publicMsg(result);
  delay(1000);
}
