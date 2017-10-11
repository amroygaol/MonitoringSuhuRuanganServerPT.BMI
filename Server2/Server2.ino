#include <DHT.h>
#include <SoftwareSerial.h>
DHT dht(2, DHT11);
SoftwareSerial RSerial(10, 11);
#define RSTxControl 3
#define RTransmit HIGH
#define RReceive LOW
#define led 13

boolean req ;
void setup() {
  // put your setup code here, to run once:
  dht.begin();
  Serial.begin(9600);
  RSerial.begin(9600);
  pinMode(RSTxControl, OUTPUT);
  pinMode(led, OUTPUT);
  digitalWrite(RSTxControl, RReceive);
}

void loop() {
  // put your main code here, to run repeatedly:
  
  digitalWrite(RSTxControl, RReceive);
  if (RSerial.available()) {
    digitalWrite(led, HIGH);
    req =  RSerial.read();
    Serial.println(req);
    if (req == 1234) {
      digitalWrite(RSTxControl, RTransmit);
      int serverTemp = dht.readTemperature();
      RSerial.write(serverTemp);
      digitalWrite(led, LOW);
      req = false;
    }
  }
}
