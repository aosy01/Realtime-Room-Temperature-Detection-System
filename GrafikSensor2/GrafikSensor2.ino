#include "DHT.h"
#include "ESP8266HTTPClient.h"
#include "ESP8266WiFi.h"

#define DHTPIN 2 
#define DHTTYPE DHT22

DHT sensor_dht(DHTPIN, DHTTYPE);

const char* ssid = "HW-Guest";
const char* password = "guest@2023.com";

const char* server = "172.27.81.15";

WiFiClient client;  // Deklarasikan client di luar loop untuk efisiensi
HTTPClient http;    // Deklarasikan HTTPClient di luar loop untuk efisiensi

void setup() {
  Serial.begin(9600);
  sensor_dht.begin();
  WiFi.hostname("NodeMCU");
  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    delay(20000);
  }
  Serial.println("Berhasil Konek ke wifi");
}

void loop() {
  float suhu = sensor_dht.readTemperature();
  int kelembapan = sensor_dht.readHumidity();

  if (isnan(suhu) || isnan(kelembapan)) {
    Serial.println("Gagal membaca data dari sensor DHT!");
    return;  // Jangan lanjutkan jika sensor gagal membaca
  }

  Serial.println("Suhu : " + String(suhu));
  Serial.println("Kelembapan: " + String(kelembapan));
  Serial.println();

  if (!client.connect(server, 80)) {
    Serial.println("Gagal terkoneksi ke web server");
    return;
  }

  String Link = "http://" + String(server) + "/grafiksensor/grafiksensor/kirimdata.php?suhu=" + String(suhu) + "&kelembapan=" + String(kelembapan);
  http.begin(client, Link);  // Mulai koneksi HTTP
  int httpCode = http.GET();  // Kirim permintaan GET

  if (httpCode > 0) {
    String respon = http.getString();
    Serial.println(respon);
  } else {
    Serial.println("Error HTTP request failed");
  }

  http.end();  // Tutup koneksi HTTP
  delay(1000);  // Tunggu 1 detik sebelum mengulang
}
