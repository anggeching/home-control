#include <Servo.h>

Servo servo1;

const int controlPin = 8; // Define the pin to read the signal from

void setup() {
  servo1.attach(9); // Attach the servo to pin 9
  pinMode(controlPin, INPUT); // Set the control pin as an input
  servo1.write(0);  // Initialize servo at 0 degrees
}

void loop() {
  int signalState = digitalRead(controlPin); // Read the signal state

  if (signalState == HIGH) {
    // If the control pin is high, rotate servo to 180 degrees
    servo1.write(180);
  } else {
    // If the control pin is low, rotate servo to 0 degrees
    servo1.write(0);
  }

  delay(100); // Add a short delay for stability
}