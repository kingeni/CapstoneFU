using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using uPLibrary.Networking.M2Mqtt;
using uPLibrary.Networking.M2Mqtt.Messages;

namespace SaveCoordinatesService
{
    class MqttReceived
    {
        public EventHandler<CommandInfo> MqttReceivedCommand;
        MqttClient client;
        string clientID;
        public MqttReceived(string hostName, string topicHost)
        {
            client = new MqttClient(hostName);
            clientID = Guid.NewGuid().ToString();
            client.Connect(clientID);
            ushort msgId = client.Subscribe(new string[] { topicHost },
            new byte[] { MqttMsgBase.QOS_LEVEL_EXACTLY_ONCE });
            client.MqttMsgSubscribed += Client_MqttMsgSubscribed;
            client.MqttMsgPublishReceived += Client_MqttMsgPublishReceived;
        }

        private void Client_MqttMsgPublishReceived(object sender, MqttMsgPublishEventArgs e)
        {
            string message = Encoding.UTF8.GetString(e.Message);
            string[] dataMessage = message.Split('|');
            if (MqttReceivedCommand != null)
            {
                if (dataMessage.Count() == 2)
                {
                    CommandInfo commandInfo = new CommandInfo
                    {
                        CommandName = dataMessage[0],
                        CommandData = dataMessage[1]
                    };
                    MqttReceivedCommand(this, commandInfo);
                }

            }
            //Console.WriteLine("Received = " + Encoding.UTF8.GetString(e.Message) + " on topic " + e.Topic);
        }

        private void Client_MqttMsgSubscribed(object sender, MqttMsgSubscribedEventArgs e)
        {
            //Console.WriteLine("Subscribed for id = " + e.MessageId);
        }

    }
    public class CommandInfo : EventArgs
    {
        public string CommandName { get; set; }
        public string CommandData { get; set; }
    }
}
