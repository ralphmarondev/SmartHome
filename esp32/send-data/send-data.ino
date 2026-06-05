#include <WiFi.h>
#include <HTTPClient.h>

const char* WIFI_SSID = "MY_WIFI";
const char* WIFI_PASSWORD = "12345678";

const char* API_URL = "http://192.168.1.100/smart-home/web/api/device_sensor_update.php";

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
      Serial.println("Request failed");
    }

    http.end();

    statusValue = !statusValue;
  } else {
    Serial.println("WiFi disconnected");
  }

  delay(5000);
}