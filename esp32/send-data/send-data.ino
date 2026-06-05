#include <WiFi.h>
#include <HTTPClient.h>
#define LIGHT 2

const char* WIFI_SSID = "WIFI_NAME";
const char* WIFI_PASSWORD = "WIFI_PASSWORD";

const char* API_URL = "http://192.168.1.149/smart-home/web/api/device_sensor_update.php";

bool statusValue = false;

void setup() {
  Serial.begin(115200);

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
  pinMode(LIGHT, OUTPUT);
}

void loop() {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;

    http.begin(API_URL);
    http.addHeader(
      "Content-Type",
      "application/x-www-form-urlencoded");

    String postData = "device_id=1&status=" + String(statusValue ? 1 : 0);
    Serial.println("--------------------");
    Serial.println("Sending:");
    Serial.println(postData);

    int httpCode = http.POST(postData);

    Serial.print("HTTP Code: ");
    Serial.println(httpCode);

    if (httpCode > 0) {
      String response = http.getString();

      Serial.println("Server Response:");
      Serial.println(response);
    } else {
      Serial.print("Request failed: ");
      Serial.println(http.errorToString(httpCode));
    }

    http.end();

    statusValue = !statusValue;
  } else {
    Serial.println("WiFi disconnected");
  }

  if (statusValue) {
    digitalWrite(LIGHT, HIGH);
  } else {
    digitalWrite(LIGHT, LOW);
  }
  delay(10000);
  statusValue = !statusValue;
}