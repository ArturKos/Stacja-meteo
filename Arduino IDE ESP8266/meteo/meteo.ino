
#include <ESP8266WiFi.h> // [biblioteka wbudowana] ESP8266 WiFi
#include "DHT.h"

#include "config.h" // plik konfiguracyjny do edycji (musi być w tym samym folderze co niniejszy plik)

WiFiClient client; // WiFi connection

#define DHTPIN_1 4          // what digital pin the DHT22 is conected to
#define DHTTYPE_DHT22 DHT22 // there are multiple kinds of DHT sensors

#define DHTPIN_2 0
#define DHTTYPE_DHT11 DHT11

DHT dht_temp_hum_in(DHTPIN_2, DHTTYPE_DHT11);
DHT dht_temp_hum_out(DHTPIN_1, DHTTYPE_DHT22);

void setup()
{
  Serial.begin(115200);         // initialize the serial port
  pinMode(LED_BUILTIN, OUTPUT); // set builtin LED for output

  while (!Serial)
  {
  } // Wait
  dht_temp_hum_out.begin();
  dht_temp_hum_in.begin();

  logonToRouter(); // logon to local Wi-Fi
}

void loop()
{
  postToRPi(); // send data to RPi
  delay(300000);
}

void logonToRouter()
{
  String exitMessage = "";
  int count = 0;
  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);
  while (WiFi.status() != WL_CONNECTED)
  {
    count++;
    // give up if more than 15 tries
    if (count > 15)
    {
      // display error code on serial monitor
      switch (WiFi.status())
      {
      case 1:
        exitMessage = "Sieć Wi-Fi niedostępna lub\nStacja zbyt daleko od punktu dostępowego lub\nNiepoprawny SSID lub hasło lub\nAccess Poin nie pracuje na częstotliwości 2.4GHz.";
        break;
      case 2: // will never show this condition
        exitMessage = "Skanowanie sieci zakończone.";
        break;
      case 3: // will never show this condition
        exitMessage = "Połączono.";
        break;
      case 4:
        exitMessage = "Błąd połączenia.";
        break;
      case 5:
        exitMessage = "Utracono połączenie.";
        break;
      case 6:
        exitMessage = "Rozłączono.";
        break;
      } // switch
      Serial.print("WiFi fail: ");
      Serial.println(exitMessage);
      // retry after 1 minute
    } // if > 15
    // otherwise if < 15 blink LED and wait 500ms before checking connection
    delay(500); // one-half second delay between checks
    Serial.print("");
  } // while not connected
  // WiFi is sucesfully connected
  Serial.println(""); // new line to show IP address
  Serial.print("Połączono z siecią Wi-Fi. Otrzymany adres IP: ");
  Serial.println(WiFi.localIP().toString()); // is toString necessary?
} // logonToRouter()

void postToRPi()
{
  // assemble and post the data
  if (client.connect(IOT_SERVER, IOT_SERVER_PORT) == true)
  {
    // Sensor readings
    float hOUT = dht_temp_hum_out.readHumidity();
    float tOUT = dht_temp_hum_out.readTemperature();
    float hIN = dht_temp_hum_in.readHumidity();
    float tIN = dht_temp_hum_in.readTemperature();
    Serial.println("Połączono z serwerem RPi.");
    // get the data to RPi
    client.print("GET /espdata.php?");
    client.print("api_key=");
    client.print(write_api_key);
    client.print("&&");
    client.print("station_id=");
    client.print(table_name);
    client.print("&&");
    client.print("tIN=");
    client.print(tIN);
    client.print("&&");
    client.print("hIN=");
    client.print(hIN);
    client.print("&&");
    client.print("tOUT=");
    client.print(tOUT);
    client.print("&&");
    client.print("hOUT=");
    client.print(hOUT);
    client.println(" HTTP/1.1");
    client.println("Host: localhost");
    client.println("Content-Type: application/x-www-form-urlencoded");
    client.println("Connection: close");
    client.println();
    client.println();
    Serial.println("Wysłano dane na serwer RPi.");
  }
  client.stop();
  Serial.println("Rozłączono z serwerem RPi.");
}
