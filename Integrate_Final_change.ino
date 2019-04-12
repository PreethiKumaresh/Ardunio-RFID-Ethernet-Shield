#include <SPI.h>
#include <Ethernet.h>
#include <MFRC522.h>
#include <ArduinoJson.h>
#include <Wire.h> 
#include <LiquidCrystal_I2C.h>

//Defining the Pins for MFRC522 that process the data channel
#define RST_PIN 9
#define SS_PIN 8

//Creating instance of class

MFRC522 mfrc522(SS_PIN, RST_PIN); //create MFRC522 instance

// Set the LCD address to 0x27 for a 16 chars and 2 line display
LiquidCrystal_I2C lcd(0x3F, 2, 1, 0, 4, 5, 6, 7, 3, POSITIVE);

EthernetClient client;

//Variable used in program
byte buffer2[30]; //reads name
int readsuccess;  //to check the presence of tag
//String uid="DB714FA3"; testing variable
//String uname="sai"; testing variable
//String uname="";
//char serv[] = "192.168.1.2"; //IP ADDRESS OF SERVER 
char serv[] = "172.16.0.206"; //IP ADDRESS OF SERVER 


void setup() {
  
  //Initialization
  
  Serial.begin(9600);
  SPI.begin();          // Init SPI bus
  mfrc522.PCD_Init();        // Init MFRC522 card
  //mfrc522.PCD_DumpVersionToSerial(); //show details of card reader module
  while (!Serial) continue;

  // Initialize Ethernet library
  byte mac[] = {0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED};
  if (!Ethernet.begin(mac)) {
    Serial.println(F("Failed to configure Ethernet"));
    return;
  }

  //----------------------------------------------------------------------
  Serial.println(F("Process has been Started")); ////shows in serial 
  lcd.begin(16,2);
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("Process Has Been");
  lcd.setCursor(0,1);
  lcd.print("Started");
  delay(2000);
  lcd.clear();
  lcd.print("Show Your Tag");
}

void loop() {
  readsuccess=check_for_rfid_tag(); //method return true(1) if tag is present and false(0) if not
  if(readsuccess){
        // Prepare key - all keys are set to FFFFFFFFFFFFh at chip delivery from the factory.
  MFRC522::MIFARE_Key key;
  for (byte i = 0; i < 6; i++) key.keyByte[i] = 0xFF;

  //some variables we need
  byte block;
  byte len;
  MFRC522::StatusCode status;

  Serial.println(F("**Card Detected:**"));

  mfrc522.PICC_DumpDetailsToSerial(&(mfrc522.uid)); //dump some details about the card

  //mfrc522.PICC_DumpToSerial(&(mfrc522.uid));      //uncomment this to see all blocks in hex
   
  Serial.print(F("Name: "));
  //byte buffer2[20];
  block = 1;

  status = mfrc522.PCD_Authenticate(MFRC522::PICC_CMD_MF_AUTH_KEY_A, 1, &key, &(mfrc522.uid)); //line 834
  if (status != MFRC522::STATUS_OK) {
    Serial.print(F("Authentication failed: "));
    Serial.println(mfrc522.GetStatusCodeName(status));
    return;
  }

  status = mfrc522.MIFARE_Read(block, buffer2, &len);
  if (status != MFRC522::STATUS_OK) {
    Serial.print(F("Reading failed: "));
    Serial.println(mfrc522.GetStatusCodeName(status));
    return;
  }

  //PRINT NAME
  String myname;
  for (uint8_t i = 0; i < 16; i++) {
    Serial.write(buffer2[i]);
    //readcard[i]=buffer2[i];
  }
  Serial.println(" ");
  Serial.print("Name in Hex: ");
  for (uint8_t i = 0; i < 16; i++) {
    Serial.print(buffer2[i],HEX);
  }
  Serial.println(F("\n**End Reading**\n"));

  delay(1000); //change value if you want to read cards faster

  mfrc522.PICC_HaltA();
  mfrc522.PCD_StopCrypto1();
  //performing http request
  delay(1000);

  Serial.println(F("Connecting..."));

  // Connect to HTTP server
  client.setTimeout(10000);
  if (!client.connect(serv, 8080)) {
    Serial.println(F("Connection failed"));
    return;
  }
  Serial.println(F("Connected!"));

  // Send HTTP request
  client.print(String("GET ") + "/labmonitor/arduino/checkuser.php?");
    client.print("rfid=");
        Serial.print("UID: ");
        for(int i=0;i<4;i++)
        {
          Serial.print(mfrc522.uid.uidByte[i],HEX);
          client.print(mfrc522.uid.uidByte[i],HEX);
        }
        //client.print(uid);
        client.print("&name=");
        Serial.println(" ");
        Serial.print("NAME: ");
        for (uint8_t i = 0; i < 16; i++) {
           Serial.write(buffer2[i]);
           client.print(buffer2[i],HEX);
          }
        //client.print(uname);
    
    client.print(" HTTP/1.1\r\nHost: " );
    client.print(serv);
    client.print("\r\nConnection: close\r\n\r\n"); //GET request for server response.
  if (client.println() == 0) {
    Serial.println(F("Failed to send request"));
    return;
  }

  // Check HTTP status
  char httpstatus[32] = {0};
  client.readBytesUntil('\r', httpstatus, sizeof(httpstatus));
  if (strcmp(httpstatus, "HTTP/1.1 200 OK") != 0) {
    Serial.print(F("Unexpected response: "));
    Serial.println(httpstatus);
    return;
  }

  // Skip HTTP headers
  char endOfHeaders[] = "\r\n\r\n";
  if (!client.find(endOfHeaders)) {
    Serial.println(F("Invalid response"));
    return;
  }

  // Allocate JsonBuffer
  // Use arduinojson.org/assistant to compute the capacity.
  const size_t capacity = JSON_OBJECT_SIZE(3) + JSON_ARRAY_SIZE(2) + 60;
  DynamicJsonBuffer jsonBuffer(capacity);

  // Parse JSON object
  JsonObject& root = jsonBuffer.parseObject(client);
  if (!root.success()) {
    Serial.println(F("Parsing failed!"));
    return;
  }

  // Extract values
  Serial.println();
  Serial.println("------------------");
  Serial.println(F("Response:"));
  Serial.println("------------------");
  Serial.println(root["status"].as<char*>());
  Serial.println(root["result"].as<char*>());
  Serial.println(root["system_info"].as<char*>());
  String s=root["status"].as<char*>();
  String r=root["result"].as<char*>();
  String sinfo=root["system_info"].as<char*>();
  Serial.print("STATUS: ");
  Serial.print(s);
  Serial.print(" RESULT: ");
  Serial.print(r);
  Serial.print(" SYSTEM INFO: ");
  Serial.print(sinfo);
  Serial.println();
  if(s.equals("success"))
    {
      if(r.equals("newuser"))
      {
        Serial.println("Welcome your system is");
        Serial.print(sinfo);
        lcd.clear();
        lcd.print("Welcome User");
        delay(2000);
        lcd.clear();
        lcd.setCursor(0,0);
        lcd.print("System Allocated:");
        lcd.setCursor(0,1);
        //delay(1000);
        //lcd.clear();
        lcd.print(sinfo);
        delay(3000);
      }
      else
      {
        Serial.println("Thank you");
        lcd.clear();
        lcd.print("Thank you");
        delay(1000);
      }
    }
    else
    {
      Serial.println("Sorry no system is free");
      lcd.clear();
      lcd.print("Welcome User");
      delay(2000);
      lcd.clear();
      lcd.setCursor(0,0);
      lcd.print("Sorry No System");
      lcd.setCursor(0,1);
      lcd.print("is Free!!");
      delay(2000);
    }
  //lcd.clear();
  //lcd.print(s);
  //delay(5000);
  //lcd.clear();
  //lcd.print("Show Your Tag");
  // Disconnect
  client.stop();
  lcd.clear();
  lcd.print("Show Your Tag");
  }
}

int check_for_rfid_tag(){
  // Look for new cards
  if ( ! mfrc522.PICC_IsNewCardPresent()) {
    return 0;
  }

  // Select one of the cards
  if ( ! mfrc522.PICC_ReadCardSerial()) {
    return 0;
  }
  return 1;
}
