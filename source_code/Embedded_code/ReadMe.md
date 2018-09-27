- Please update newest CP210x driver in this folder. This driver can make your upload code become automatic, do not need push boot button ever.
- Install ESP32 board for Arduino IDE. Following this tutorial: https://randomnerdtutorials.com/installing-the-esp32-board-in-arduino-ide-windows-instructions/
- Install BLE library for ESP32 to Arduino IDE with file: "ESP32_BLE_Arduino-master.zip"
- Open folder BLE_scan_demoOK, open file BLE_scan_demoOK.ino.
	+ At this file, change your SSID, password, mqtt_server, mqtt_port, mqtt_user, mqtt_pass, mqtt_client_name, mqtt_topic as your config at broker and Wifi config.
	+ Go to Tools tab: change the value of:	
		* Board to ESP32 Dev Module.
		* Upload speed: 512000.
		* Partition Scheme: No OTA.
		* Core debug level: None
		* Port: Your board port.
	+ Upload this file to your board.
	+ Follow the result at your serial command or Broker Reciever windows!
- In this code, we will send Mac-Address and RSSI signals to Local broker base on Raspberry. 
