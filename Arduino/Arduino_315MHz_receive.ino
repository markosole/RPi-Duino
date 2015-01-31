/*
  RF_Sniffer
 
  Hacked from http://code.google.com/p/rc-switch/
 
  by @justy to provide a handy RF code sniffer
  
  
  Program koji uspjesno prima komande i na osnovu primljenih vrijednosti pali
  odredjenu LED diodu. Plavu, zelenu, crvenu.
*/
 
#include "RCSwitch.h"
#include <stdlib.h>
#include <stdio.h>
RCSwitch mySwitch = RCSwitch();
int red = 13;
int green = 12;
int blue = 8;
int BUZZER = 7;

void setup() {
  Serial.begin(9600);
  mySwitch.enableReceive(0);  // Receiver on inerrupt 0 =&gt; that is pin #2
  mySwitch.setProtocol(1); 
 // mySwitch.setPulseLength(350);
 
// mySwitch.setReceivedProtocol(2)
  pinMode(red, OUTPUT);
  pinMode(green, OUTPUT);
  pinMode(blue, OUTPUT);
  digitalWrite(red, LOW);
  digitalWrite(green, LOW);
  digitalWrite(blue, LOW);
  pinMode(BUZZER, OUTPUT);
 digitalWrite(BUZZER,HIGH);
}
 
void loop() {
  if (mySwitch.available()) {
 
    int value = mySwitch.getReceivedValue();
    int protokolPrimanja = mySwitch.getReceivedProtocol();
    
   delay(350);
   
   if  (value == 0) {
     
      Serial.print("Nepoznata komanda \n");
    } else {
 /*    moj cod switch case */
 
 /*   CRVENA */
 if (value == 222){
   digitalWrite(red, HIGH);
   beep(50);
  
 } else {
    if (value == 2229){
   digitalWrite(red, LOW);
   beep(50);
   
 }
 }  

/*    ZELENA */
 if (value == 333){
   digitalWrite(green, HIGH);
   beep(50);
 
 } else {
    if (value == 3339){
   digitalWrite(green, LOW);
   beep(50);
 }
 }  
 /*    PLAVA   */
 if (value == 444){
   digitalWrite(blue, HIGH);
   beep(50);
  
 } else {
    if (value == 4449){
   digitalWrite(blue, LOW);
   beep(50);
 }
 }   
 /*    moj cod switch case */     
      
      
      
      if  (value == 0) {
     
      Serial.print("Primljena komanda je 0. Pogresno! \n");
    }
     Serial.print("Received ");
      Serial.print( mySwitch.getReceivedValue() );
      Serial.print(" / ");
      Serial.print( mySwitch.getReceivedBitlength() );
      Serial.print("bit ");
      Serial.print("Protocol: ");
      Serial.println( mySwitch.getReceivedProtocol() );
    }
 
    mySwitch.resetAvailable();
 
  }
}
void beep(int tempo){
  digitalWrite(BUZZER, LOW);
  delay(tempo);
  digitalWrite(BUZZER, HIGH);
  delay(tempo);
} 
