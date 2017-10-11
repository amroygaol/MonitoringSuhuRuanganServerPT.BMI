#include <DHT.h>
#include <Wire.h>
#include <LCD.h>
#include <LiquidCrystal_I2C.h>
#include <Ethernet.h> //deklarasi library Ethernet Shield
#include <SPI.h> //deklarasi library ethernet
#include <SoftwareSerial.h>
#define DHTPIN1 2
#define DHTTYPE DHT11
#define SSerialTxControl 3
#define RS485Transmit    HIGH
#define RS485Received    LOW
#define Pin13LED         13
DHT dht(DHTPIN1, DHTTYPE);
EthernetClient client; //deklarasi nama client
LiquidCrystal_I2C  lcd(0x3F, 2, 1, 0, 4, 5, 6, 7);
SoftwareSerial RS485Serial(0, 1);
SoftwareSerial serialSIM800(4, 5);
const int relay1 = 6;
const int relay2 = 7;
byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED }; // RESERVED MAC ADDRESS
byte ip[] = {192, 168, 1, 177}; //ip address ethernet shield
unsigned long previousMillis = 0;
unsigned long previousMillis2 = 0;
const long interval = 60000; //interval untuk proses millis
const long intervalRelay = 1000;
int server1Temp;
int server2Temp;
int server1TempPrev = 0;
int server2TempPrev = 0;
bool req ;
int relay1State = LOW;
int relay2State = LOW;

void readData() {
  delay(900);
  RS485Serial.listen();
  server1Temp = dht.readTemperature();
  digitalWrite(SSerialTxControl, RS485Transmit);
  RS485Serial.write(true);
  Serial.println(true);
  digitalWrite(SSerialTxControl, RS485Received);
  delay(20);
  if (RS485Serial.available()) {
    server2Temp = RS485Serial.read();
  }
  Serial.println(server2Temp);
}
void setup()
{
  dht.begin();
  lcd.begin (16, 2); 
  lcd.setBacklightPin(3, POSITIVE);
  lcd.setBacklight(HIGH);
  Serial.begin(9600);
  pinMode(Pin13LED, OUTPUT);
  pinMode(SSerialTxControl, OUTPUT);
  RS485Serial.begin(9600);
  serialSIM800.begin(9600);
  readData();
  Ethernet.begin(mac, ip);
  pinMode(relay1, OUTPUT);
  pinMode(relay2, OUTPUT);
}

void display() {
  lcd.setCursor (0, 0);
  lcd.print("Server 1 : ");
  lcd.print(server1Temp);
  lcd.setCursor (14, 0);
  lcd.print("'C");
  lcd.setCursor (0, 1);
  lcd.print("Server 2 : ");
  lcd.print(server2Temp);
  lcd.setCursor (14, 1);
  lcd.print("'C");
}

void uploadData() {
  if (client.connect("192.168.1.176", 80)) { 
    Serial.println("Server connection OK");
    client.print("GET /suhuServer/oke.php?");
    client.print("temp1=");
    client.print(server1Temp);
    client.print("&");
    client.print("temp2=");
    client.print(server2Temp);
    client.println(" HTTP/1.1");
    client.println("Host: 192.168.1.176");
    client.println("Connection: close");
    client.println();
    client.println();
    client.stop();
  }
}

void notifikasi() {
  unsigned long currentMillis2 = millis();
  if (currentMillis2 - previousMillis2 >= intervalRelay) {
    previousMillis2 = currentMillis2;
    if (server1Temp >= 24) {
      Serial.println("Hidupkan relay1");
      if (relay1State == LOW) {
        relay1State = HIGH;
      } else {
        relay1State = LOW;
      }
      digitalWrite(relay1, relay1State);
    }
    else if (server1Temp <= 24) {
      digitalWrite(relay1, HIGH);
    }
    if (server2Temp >= 24) {
      Serial.println("Hidupkan relay2");
      if (relay2State == LOW) {
        relay2State = HIGH;
      } else {
        relay2State = LOW;
      }
      digitalWrite(relay2, relay2State);
    }
    else if (server2Temp <= 24) {
      digitalWrite(relay2, HIGH);
    }
  }
}

void gsm() {
  serialSIM800.listen();
  serialSIM800.write("AT+CMGF=1\r\n");
  delay(2000);
  serialSIM800.write("AT+CMGS=\"+6283848262500\"\r\n");
  delay(2000);
  serialSIM800.print("Suhu Server 1 : \n");
  serialSIM800.println(server1Temp);
  serialSIM800.print("Suhu Server 2 : \n");
  serialSIM800.println(server2Temp);
  delay(2000);
  serialSIM800.write((char)26);
}

void loop() {
  RS485Serial.flush();
  serialSIM800.flush();
  readData();
  display();
  notifikasi();
  unsigned long currentMillis = millis();
  if (server1TempPrev != server1Temp || server2TempPrev != server2Temp) {
    lcd.clear();
    server1TempPrev = server1Temp;
    server2TempPrev = server2Temp;
    display();
  }
  if (currentMillis - previousMillis >= interval) {
    previousMillis = currentMillis;
    uploadData();
    if (server1Temp >= 24 || server2Temp >= 24) {
      gsm();
      
    }
  }
}



