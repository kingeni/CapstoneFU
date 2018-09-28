using MySql.Data.MySqlClient;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Diagnostics;
using System.Linq;
using System.ServiceProcess;
using System.Text;
using System.Threading.Tasks;
using uPLibrary.Networking.M2Mqtt;
using uPLibrary.Networking.M2Mqtt.Messages;

namespace SaveCoordinatesService
{
    public partial class Service1 : ServiceBase
    {
        public Service1()
        {
            InitializeComponent();
        }

        protected override void OnStart(string[] args)
        {
            string BrokerAddress = "broker.hivemq.com";

            MqttClient client = new MqttClient(BrokerAddress);
            client.MqttMsgPublishReceived += client_MqttMsgPublishReceived;
            var clientId = Guid.NewGuid().ToString();
            client.Connect(clientId);

            // whole topic
            string Topic = "presence";
            // subscribe to the topic with QoS 2
            client.Subscribe(new string[] { Topic }, new byte[] { 2 });   // we need arrays as parameters because we can subscribe to different topics with one call
        }

        protected override void OnStop()
        {
        }


        static void client_MqttMsgPublishReceived(object sender, MqttMsgPublishEventArgs e)
        {
            //Coordinates|B123:5:6
            string ReceivedMessage = Encoding.UTF8.GetString(e.Message);
            if (ReceivedMessage.Contains("Coordinates"))
            {
                string[] ele = ReceivedMessage.Split('|');
                string info = ele[1];
                string[] ele1 = info.Split(':');
                try
                {
                    //This is my connection string i have assigned the database file address path  
                    string MyConnection2 = "datasource=localhost;port=3306;username=root;password=123456;SslMode = none";
                    //This is my insert query in which i am taking input from the user through windows forms  
                    string Query = "insert into beacon_webapp.object_coordinates(object_id,x,y) values('" + ele1[0] + "','" + ele1[1] + "','" + ele1[2] + "');";
                    //This is  MySqlConnection here i have created the object and pass my connection string.  
                    MySqlConnection MyConn2 = new MySqlConnection(MyConnection2);
                    //This is command class which will handle the query and connection object.  
                    MySqlCommand MyCommand2 = new MySqlCommand(Query, MyConn2);
                    MySqlDataReader MyReader2;
                    MyConn2.Open();
                    MyReader2 = MyCommand2.ExecuteReader();     // Here our query will be executed and data saved into the database.  
                    while (MyReader2.Read())
                    {
                    }
                    MyConn2.Close();
                }
                catch (Exception)
                {
                    //ingnored
                }
            }
        }
    }
}
