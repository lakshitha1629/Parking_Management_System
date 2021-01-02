#include <Servo.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#define HOST "myparkbot.000webhostapp.com" // Enter HOST URL without "http:// " and "/" at the end of URL
#define WIFI_SSID "Jayathilaka"            // WIFI SSID here
#define WIFI_PASSWORD "fullmooN68"         // WIFI password here

Servo servo1;
Servo servo2;

String ent_exi = "1";

void setup()
{
    Serial.begin(9600);

    servo1.attach(D6); //D6 entrance
    servo2.attach(D7); //D7 exit
    servo1.write(0);
    servo2.write(0);
    delay(2000);

    Serial.println("Communication Started \n\n");
    delay(1000);
    WiFi.mode(WIFI_STA);
    WiFi.begin(WIFI_SSID, WIFI_PASSWORD);
    Serial.print("Connecting to ");
    Serial.print(WIFI_SSID);
    while (WiFi.status() != WL_CONNECTED)
    {
        Serial.print(".");
        delay(500);
    }
    Serial.println();
    Serial.print("Connected to ");
    Serial.println(WIFI_SSID);
    Serial.print("IP Address is : ");
    Serial.println(WiFi.localIP());
    delay(30);
}

void loop()
{
    HTTPClient http;

    String GetAddress, LinkGet, getData;

    GetAddress = "http://myparkbot.000webhostapp.com/NodeMCU_Get_En_Ex.php";
    LinkGet = GetAddress; //--> Make a Specify request destination
    getData = "ID=" + ent_exi;
    Serial.println("----------------Connect to Server-----------------");
    Serial.println("Get LED Status from Server or Database");
    Serial.print("Request Link : ");
    Serial.println(LinkGet);
    http.begin(LinkGet);                                                 //--> Specify request destination
    http.addHeader("Content-Type", "application/x-www-form-urlencoded"); //Specify content-type header
    int httpCodeGet = http.POST(getData);                                //--> Send the request
    String payloadGet = http.getString();                                //--> Get the response payload from server
    Serial.print("Response Code : ");                                    //--> If Response Code = 200 means Successful connection, if -1 means connection failed. For more information see here : https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
    Serial.println(httpCodeGet);                                         //--> Print HTTP return code
    Serial.print("Returned data from Server : ");
    Serial.println(payloadGet); //--> Print request response payload

    if (payloadGet == "1")
    {
        servo1.write(180);
        delay(1000);
        servo1.write(90);
        delay(1000);
    }
    else
    {
        servo2.write(180);
        delay(1000);
        servo2.write(90);
        delay(1000);
    }
    //----------------------------------------

    Serial.println("----------------Closing Connection----------------");
    http.end(); //--> Close connection
    Serial.println();
    Serial.println("Please wait 5 seconds for the next connection.");
    Serial.println();

    // servo1.write(180);
    // servo2.write(180);
    // delay(1000);

    // servo1.write(90);
    // servo2.write(90);
    // delay(1000);
}