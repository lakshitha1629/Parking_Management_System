#include <Servo.h>

const int ProxSensorEN01 = D0;
const int ProxSensorEN02 = D1;
const int ProxSensorEX01 = D2;
const int ProxSensorEX02 = D3;

//MACROS are defined here
Servo ServoEN;
Servo ServoEX;

void setup()
{
    //put your setup code here, to run once:
    Serial.begin(9600);
    pinMode(D0, INPUT);
    ServoEN.attach(D4);
    pinMode(D1, INPUT);

    pinMode(D2, INPUT);
    ServoEX.attach(D5);
    pinMode(D3, INPUT);
}

void loop()
{
    //put your main code here, to run repeatedly:
    if ((!(digitalRead(D0))) && payloadGet == "1")
    {
        Serial.println("--> Open Entrance Gate");
        ServoEN.write(90);
    }
    if ((!(digitalRead(D1))) && payloadGet == "1")
    {
        Serial.println("--> Close Entrance Gate");
        ServoEN.write(180);
    }

    if ((!(digitalRead(D3))) && payloadGet == "0")
    {
        Serial.println("--> Open Exit Gate");
        ServoEX.write(90);
    }
    if ((!(digitalRead(D2))) && payloadGet == "0")
    {
        Serial.println("--> Close Exit Gate");
        ServoEX.write(0);
    }
}