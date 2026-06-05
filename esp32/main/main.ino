#define LIGHT_PIN 4
#define FAN_PIN 5
#define DOOR_PIN 6

bool lightState = false;
bool fanState = false;
bool doorState = false;

void initializeDevices()
{
    pinMode(LIGHT_PIN, OUTPUT);
    pinMode(FAN_PIN, OUTPUT);
    pinMode(DOOR_PIN, OUTPUT);

    digitalWrite(LIGHT_PIN, LOW);
    digitalWrite(FAN_PIN, LOW);
    digitalWrite(DOOR_PIN, LOW);
}

void applyDeviceStates()
{
    digitalWrite(
        LIGHT_PIN,
        lightState ? HIGH : LOW
    );

    digitalWrite(
        FAN_PIN,
        fanState ? HIGH : LOW
    );

    digitalWrite(
        DOOR_PIN,
        doorState ? HIGH : LOW
    );
}

void updateDeviceState(
    int deviceId,
    bool status
)
{
    switch(deviceId)
    {
        case 1:
            lightState = status;
            break;

        case 2:
            fanState = status;
            break;

        case 3:
            doorState = status;
            break;
    }

    applyDeviceStates();
}

void toggleLight()
{
    lightState = !lightState;

    digitalWrite(
        LIGHT_PIN,
        lightState ? HIGH : LOW
    );

    Serial.println(
        lightState ?
        "Light ON" :
        "Light OFF"
    );
}

void toggleFan()
{
    fanState = !fanState;

    digitalWrite(
        FAN_PIN,
        fanState ? HIGH : LOW
    );
}

void toggleDoor()
{
    doorState = !doorState;

    digitalWrite(
        DOOR_PIN,
        doorState ? HIGH : LOW
    );
}

void setup() {
  Serial.begin(115200);
  
  initializeDevices();

    // fetch from:
    // api/device_get_list.php

    updateDeviceState(1, true);
    updateDeviceState(2, false);
    updateDeviceState(3, true);
}

unsigned long previousMillis = 0;

void loop() {
  if(millis() - previousMillis >= 5000)
  {
        previousMillis = millis();
        toggleLight();
  }
}
