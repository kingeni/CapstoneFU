# Tracking Indoor Object using Bluetooth Low Energy		
  The system uses low-power bluetooth technology integrated in devices (device 1) mounted on the objects to be monitored. These devices will continuously emit an identifying information for that device. 
   Another type of device (device 2) is attached to the space around the architecture. It will pick up waves emitted by devices mounted on the objects.
     After device 2 receives the signal, it sends the result to the central gateway using the wifi signal. The central gateway will calculate the position of the object by algorithm to determine the location based on the received signal strength and then send the results to the online server. We can track the exact location of the object with a radius of <0.5m via the administration website.
    At the site admin, you can know the location of the object, set the rules where the object or group of objects can access. You can also create rules for sending alarms, turning on alarms whenever there are any location changes or anomalies that you have set.
   The pros point of the project is that device 1 can operate up to 3 years to replace the battery. It is possible to accurately determine indoor locations that GPS or other location-based technologies can not meet. Bring ease and convenience to the manager by setting rules by individual or group of objects.
# Install progame 
  npm install mosca --save
  
