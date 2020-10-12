#include <ESP8266WiFi.h>//library for esp8266 wfi module

 
const char* ssid     = ""; //set your ssid(your hotspot or wifi name)
const char* password = ""; //your wifi/hotspot password
const char* host = ""; //your host name


void setup() {
  Serial.begin(115200);//frequency to transfer the code
  delay(100);
  Serial.println();
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);
  
  WiFi.begin(ssid, password); //connect the wifi with the ssid and password you enter
  while (WiFi.status() != WL_CONNECTED) { //if wifi is not connected
    delay(500);
    Serial.print("."); //retry connection
  }

 //if succesfuly connected to, enter here
  Serial.println("");
  Serial.println("WiFi connected");  
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
  Serial.print("Netmask: ");
  Serial.println(WiFi.subnetMask());
  Serial.print("Gateway: ");
  Serial.println(WiFi.gatewayIP());
}

void loop() {

  Serial.print("connecting to ");
  Serial.println(host);

  WiFiClient client1; //WiFiClient creates a client that can connect to to a specified internet IP address and port as defined in
  WiFiClient client2;
  WiFiClient client3;
  WiFiClient client4;
  const int httpPort = 80; // define the http port number
  
  if (!client1.connect(host, httpPort)) {
    Serial.println("connection failed");
    return;
  }
  if (!client2.connect(host, httpPort)) {
    Serial.println("connection failed");
    return;
  }  
  if (!client3.connect(host, httpPort)) {
    Serial.println("connection failed");
    return;
  }  
  if (!client4.connect(host, httpPort)) {
    Serial.println("connection failed");
    return;
  }  
struct BME{
  float temp;
  float hum;
  float pres; 
  float gas;
  float alti;
}B;

struct GPS{
  float lat;
  float lon;
}S;

struct Battery{
  float percent;
}P;

struct Gyro{
  float angX;
  float angY;
  float angZ;
  float accX;
  float accY;
  float accZ;
}G;

  String url1 = "/SATELLITE/API/BMEpost.php?temperature=" + String(B.temp)+ "&humidity=" + String(B.hum) + "&pressure=" + String(B.pres) + "&gas=" + String(B.gas) + "&altitude=" + String(B.alti); // combine values of temp and hum to form a URL link

  String url2 = "/SATELLITE/API/GPSpost.php?lat="+String(S.lat) "&lon=" + String(S.lon);

  String url3 = "/SATELLITE/API/BATTERYpost.php?percent="+String(P.percent);
  
  String url4 = "/SATELLITE/API/GYROpost.php?angX=" + String(G.angX) + "&angY=" + String(G.angY) + "&angZ=" + String(G.angZ) + "&accX=" + String(G.accX) + "&accY=" + String(G.accY) + "&accZ=" + String(G.accZ);
  //Serial.print("Requesting URL: ");
  //Serial.println(url);
  

  client1.print(String("GET ") + url1 + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" + 
               "Connection: close\r\n\r\n");

  delay(500);
  //delay for 5 seconds
  client2.print(String("GET ") + url2 + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" + 
               "Connection: close\r\n\r\n");

  delay(500);

  client3.print(String("GET ") + url3 + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" + 
               "Connection: close\r\n\r\n");

  delay(500);

  client4.print(String("GET ") + url4 + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" + 
               "Connection: close\r\n\r\n");

  delay(500);
  //delay for 5 seconds
  
  while(client1.available()){
    String line = client1.readStringUntil('\r'); // read the string until the compiler reads a '\r'
    Serial.print(line);
  }
  while(client2.available()){
    String line = client2.readStringUntil('\r'); // read the string until the compiler reads a '\r'
    Serial.print(line);
  }
 
  while(client3.available()){
    String line = client3.readStringUntil('\r'); // read the string until the compiler reads a '\r'
    Serial.print(line);
  }

  while(client4.available()){
    String line = client4.readStringUntil('\r'); // read the string until the compiler reads a '\r'
    Serial.print(line);
  }    
  Serial.println();
  Serial.println("closing connection");
  delay(3000);
}
