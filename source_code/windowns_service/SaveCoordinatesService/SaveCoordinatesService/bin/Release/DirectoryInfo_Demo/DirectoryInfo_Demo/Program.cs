using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace DirectoryInfo_Demo
{
    class Program
    {
        static void Main(string[] args)
        {
            //DirectoryInfo dir = new DirectoryInfo(@"D:\phpMQTT-master");

            //Console.WriteLine("*** Directory Info ***");
            //Console.WriteLine("FullName: {0}",dir.FullName);
            //Console.WriteLine("Name: {0}", dir.Name);
            //Console.WriteLine("Parent: {0}", dir.Parent);
            //Console.WriteLine("Creation: {0}", dir.CreationTime);
            //Console.WriteLine("Attributes: {0}", dir.Attributes);
            //Console.WriteLine("Root: {0}", dir.Root);
            //Console.WriteLine("**********************");

            //#region List stats on all *.BMP files
            //FileInfo[] allFiles = dir.GetFiles("*.*");

            //Console.WriteLine("Found {0} *.* files\n",allFiles.Count());
            //foreach (FileInfo item in allFiles)
            //{
            //    Console.WriteLine("**********************");
            //    Console.WriteLine("File name: {0}", item.Name);
            //    Console.WriteLine("File site: {0}", item.Length);
            //    Console.WriteLine("Creation: {0}", item.CreationTime);
            //    Console.WriteLine("Attributes: {0}", item.Attributes);
            //    Console.WriteLine("**********************\n");
            //}
            //Console.ReadLine();
            //#endregion

            string s;
            string fileName = @"D:\data.txt";
            StringBuilder sb = new StringBuilder();
            sb.AppendLine("hello");
            sb.AppendLine("word");
            sb.Append("Goodbye");
            StreamWriter sw = StreamWriter(fileName);
            File.WriteAllText(fileName, sb.ToString());
            FileInfo fileInfo = new FileInfo(@"D:\data.txt");
            StreamReader sr = fileInfo.OpenText();
            while ((s = sr.ReadLine()) != null)
            {
                Console.WriteLine(s);
            }
            Console.ReadLine();
        }
    }
}
