#include <WiFi.h>
#include <HTTPClient.h>

#define LIGHT 2

const char* WIFI_SSID = "WIFI_NAME";
const char* WIFI_PASSWORD = "WIFI_PASSWORD";

const char* API_URL = "http://192.168.1.149/smart-home/web/api/device_get_status.php?device_id=1";

void setup() {
  Serial.begin(115200);

  pinMode(LIGHT, OUTPUT);

  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);

  Serial.print("Connecting to WiFi");

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println();
  Serial.println("Connected!");
  Serial.print("IP Address: ");
  Serial.println(WiFi.localIP());
}

bool getLightStatus() {

  if (WiFi.status() != WL_CONNECTED) {
    Serial.println("WiFi disconnected");
    return false;
  }

  HTTPClient http;

  http.begin(API_URL);

  int httpCode = http.GET();

  if (httpCode <= 0) {

    Serial.print("Request failed: ");
    Serial.println(http.errorToString(httpCode));

    http.end();
    return false;
  }

  String response = http.getString();

  Serial.println("Response:");
  Serial.println(response);

  http.end();

  if (response.indexOf("\"status\":1") >= 0) {
    return true;
  }

  return false;
}

void loop() {

  bool lightStatus = getLightStatus();

  if (lightStatus) {
    digitalWrite(LIGHT, HIGH);
    Serial.println("LIGHT ON");
  } else {
    digitalWrite(LIGHT, LOW);
    Serial.println("LIGHT OFF");
  }

  delay(3000);
}