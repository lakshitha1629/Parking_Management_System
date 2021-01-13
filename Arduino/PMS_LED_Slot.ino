#include <Servo.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#define HOST "myparkbot.000webhostapp.com" // Enter HOST URL without "http:// " and "/" at the end of URL
#define WIFI_SSID "Jayathilaka"            // WIFI SSID here
#define WIFI_PASSWORD "fullmooN68"         // WIFI password here

// defines pins numbers
const int trigPin = D4; //D4
const int echoPin = D3; //D3
int ledPin2 = D0;       //D0 Green
int ledPin3 = D1;       //D1 Red
int ledPin4 = D2;       //D2 yellow
Servo servo1;           //Slot servo
// defines variables
long duration;
int distance;

// Declare global variables which will be uploaded to server
String space_no = "1";
String status_val = "Null";

String sendval, sendval2, postData;

void setup()
{
    Serial.begin(9600);
    servo1.attach(D6); //D6 Slot servo
    servo1.write(0);
    delay(2000);

    pinMode(trigPin, OUTPUT); // Sets the trigPin as an Output
    pinMode(echoPin, INPUT);  // Sets the echoPin as an Input
    pinMode(ledPin2, OUTPUT); // sets the pin as output
    pinMode(ledPin3, OUTPUT); // sets the pin as output
    pinMode(ledPin4, OUTPUT); // sets the pin as output
    Serial.begin(9600);       // Starts the serial communication

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

    sendval = String(space_no);
    if (status_val != "Null")
    {
        sendval2 = String(status_val);
    }

    postData = "sendval=" + sendval + "&sendval2=" + sendval2;

    http.begin("http://myparkbot.000webhostapp.com/NodeMCU.php");        // Connect to host where MySQL databse is hosted
    http.addHeader("Content-Type", "application/x-www-form-urlencoded"); //Specify content-type header

    int httpCode = http.POST(postData); // Send POST request to php file and store server response code in variable named httpCode
    Serial.println("Values are, sendval = " + sendval + " and sendval2 = " + sendval2);

    if (httpCode == 200)
    {
        Serial.println("Values uploaded successfully.");
        Serial.println(httpCode);
        String webpage = http.getString(); // Get html webpage output and store it in a string
        Serial.println(webpage + "\n");
    }
    else
    {
        Serial.println(httpCode);
        Serial.println("Failed to upload values. \n");
        http.end();
        return;
    }

    // Clears the trigPin
    digitalWrite(trigPin, LOW);
    delayMicroseconds(2);

    // Sets the trigPin on HIGH state for 10 micro seconds
    digitalWrite(trigPin, HIGH);
    delayMicroseconds(10);
    digitalWrite(trigPin, LOW);

    // Reads the echoPin, returns the sound wave travel time in microseconds
    duration = pulseIn(echoPin, HIGH);

    // Calculating the distance
    distance = duration * 0.034 / 2;
    // Prints the distance on the Serial Monitor
    Serial.print("Distance: ");
    Serial.println(distance);

    if (distance < 10)
    {
        status_val = "Active";
        servo1.write(0);
        digitalWrite(ledPin2, LOW);  // Order the LED on Pin2 to go off Green
        digitalWrite(ledPin3, HIGH); // Order the LED on Pin3 to light up Red
    }
    else
    {
        status_val = "Inactive";
        servo1.write(90);
        digitalWrite(ledPin2, HIGH); // Order the LED on Pin2 to light up Green
        digitalWrite(ledPin3, LOW);  // Order the LED on Pin3 to go off Red
    }

    //delay(2000);

    // put your main code here, to run repeatedly:
    //HTTPClient http; //--> Declare object of class HTTPClient

    //----------------------------------------Getting Data from MySQL Database
    String GetAddress, LinkGet, getData;

    GetAddress = "http://myparkbot.000webhostapp.com/NodeMCU_Get.php";
    LinkGet = GetAddress; //--> Make a Specify request destination
    getData = "ID=" + space_no;
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

    if (payloadGet == "Reserved1" || payloadGet == "Inactive1")
    {
        Serial.println("--> Open Slot Gate");
        servo1.write(90);
    }

    if (payloadGet == "Reserved1" || payloadGet == "Reserved0")
    {
        digitalWrite(ledPin4, HIGH); //--> Turn off Led
    }
    else
    {
        digitalWrite(ledPin4, LOW); //--> Turn off Led
    }
    //----------------------------------------

    Serial.println("----------------Closing Connection----------------");
    http.end(); //--> Close connection
    Serial.println();
    Serial.println("Please wait 5 seconds for the next connection.");
    Serial.println();
}