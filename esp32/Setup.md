# 🔧 ESP32 Setup Guide using Arduino IDE

This guide helps you install and configure the Arduino IDE to program ESP32 boards easily.

---

## 📌 Requirements

Before starting, make sure you have:

* 💻 Windows / macOS / Linux PC
* 🔌 ESP32 development board
* 🔗 USB data cable (NOT charge-only)
* 📦 Arduino IDE installed (latest version recommended)

Download Arduino IDE:
👉 [https://www.arduino.cc/en/software](https://www.arduino.cc/en/software)

---

## ⚙️ Step 1: Install ESP32 Board Package

1. Open **Arduino IDE**
2. Go to:
   **File → Preferences**
3. Find this field:
   **"Additional Board Manager URLs"**
4. Paste this link:
```
https://espressif.github.io/arduino-esp32/package_esp32_index.json
```
5. Click **OK**
6. 
---

## 📦 Step 2: Install ESP32 Boards

1. Go to:
   **Tools → Board → Boards Manager**
2. Search:
   `esp32`
3. Install:
   **“esp32 by Espressif Systems”**

⏳ This may take a few minutes depending on internet speed.

---

## 🧠 Step 3: Select Your ESP32 Board

1. Go to:
   **Tools → Board**
2. Select something like:

* ESP32 Dev Module (most common)

---

## 🔌 Step 4: Install USB Drivers (if needed)

If your ESP32 is not detected:

* CH340 driver (common clones):
  [https://www.wch.cn/downloads/CH341SER_ZIP.html](https://www.wch.cn/downloads/CH341SER_ZIP.html)

* CP2102 driver (Silicon Labs):
  [https://www.silabs.com/developers/usb-to-uart-bridge-vcp-drivers](https://www.silabs.com/developers/usb-to-uart-bridge-vcp-drivers)

---

## 🔍 Step 5: Select Port

1. Plug in ESP32 via USB
2. Go to:
   **Tools → Port**
3. Select the COM port that appears (e.g., COM3, COM6, etc.)

❗ If no port appears:

* Try another USB cable
* Try another USB port
* Check driver installation

---

## 🚀 Step 6: Upload Your First Code

Try this simple test sketch:

```cpp
void setup() {
  Serial.begin(115200);
  Serial.println("ESP32 is working!");
}

void loop() {
}
```

Click:

* ✔ Upload button (right arrow)

---

## ⚠️ Common Issues & Fixes

### ❌ “Failed to connect”

* Hold **BOOT button** while uploading
* Release when upload starts

### ❌ No COM port

* Cable might be charge-only ⚡
* Driver missing

### ❌ Upload stuck / slow

* Lower upload speed in Tools
* Try another USB port

---

## 🎯 Done!

If everything works, your ESP32 is now ready for IoT, sensors, automation, and more 🔥
