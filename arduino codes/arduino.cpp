int ledPins[] = {3, 5, 6, 9, 10, 11}; // Array of LED pins
int numLeds = sizeof(ledPins) / sizeof(ledPins[0]); // Number of LEDs
int ledStates[6] = {0, 0, 0, 0, 0,0}; // Initial states of LEDs (0 = off, 1 = on)

void setup() {
  Serial.begin(9600);
  for (int i = 0; i < numLeds; i++) {
    pinMode(ledPins[i], OUTPUT);
    digitalWrite(ledPins[i], LOW); // Turn off all LEDs initially
  }
}

void loop() {
  if (Serial.available()) {
    String command = Serial.readStringUntil('\n');
    int delimiterIndex = command.indexOf(':');
    if (delimiterIndex > 0) {
      int room = command.substring(0, delimiterIndex).toInt();
      int state = command.substring(delimiterIndex + 1).toInt();
      
      if (room == -1) { // Assuming -1 is used for the reset command
        resetAllLeds();
      } else if (room >= 0 && room < numLeds) {
        ledStates[room] = state;
        analogWrite(ledPins[room], state ? 255 : 0); // Adjust to your fading logic
      }
    }
  }
}

void resetAllLeds() {
  for (int i = 0; i < numLeds; i++) {
    ledStates[i] = 0;
    analogWrite(ledPins[i], 0); // Turn off all LEDs
  }
}
