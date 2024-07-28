// Servo Control
Servo servo1;
const int servoPin = 9; // Servo connected to pin 9
const int controlPin = 11; // Pin to control the servo

// Manual Control
const int switchPins[] = {8, 12, 13}; // Pins connected to the slide switches
int switchStates[3] = {0, 0, 0};      // Array to hold the current state of each switch
int lastSwitchStates[3] = {0, 0, 0};  // Array to hold the last state of each switch

// Web Control
int ledPins[] = {3, 5, 6, 9, 10}; // making pin 11 input pin
int numLeds = sizeof(ledPins) / sizeof(ledPins[0]); // Number of LEDs
int ledStates[6] = {0, 0, 0, 0, 0, 0}; // Initial states of LEDs (0 = off, 1 = on)

void setup() {
  // Setup for manual control
  for (int i = 0; i < 3; i++) {
    pinMode(switchPins[i], INPUT_PULLUP); // Set the slide switch pins as input with internal pull-up resistors
  }

  // Setup for web control
  for (int i = 0; i < numLeds; i++) {
    pinMode(ledPins[i], OUTPUT);
    digitalWrite(ledPins[i], LOW); // Turn off all LEDs initially
  }

  Serial.begin(9600); // Initialize serial communication
}

void loop() {
  // Manual Control
  for (int i = 0; i < 3; i++) {
    switchStates[i] = digitalRead(switchPins[i]);
    
    if (switchStates[i] != lastSwitchStates[i]) {
      if (switchStates[i] == LOW) { // Button pressed
        int ledIndex = getLedIndexForSwitch(i);
        if (ledIndex >= 0) {
          ledStates[ledIndex] = !ledStates[ledIndex];
          analogWrite(ledPins[ledIndex], ledStates[ledIndex] ? 255 : 0); // Toggle LED state
          sendUpdateToWeb(ledIndex, ledStates[ledIndex]);
        }
      }
      delay(50); // Debounce delay
    }
    
    lastSwitchStates[i] = switchStates[i];
  }

  // Web Control
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

  delay(10); // Small delay for stability
}

void resetAllLeds() {
  for (int i = 0; i < numLeds; i++) {
    ledStates[i] = 0;
    analogWrite(ledPins[i], 0); // Turn off all LEDs
  }
}

int getLedIndexForSwitch(int switchIndex) {
  // Map switch index to LED index
  switch (switchIndex) {
    case 0: return 0; // Switch at pin 8 controls LED at index 0 (pin 3)
    case 1: return 1; // Switch at pin 12 controls LED at index 1 (pin 5)
    case 2: return 3; // Switch at pin 13 controls LED at index 3 (pin 9)
    default: return -1;
  }
}

void sendUpdateToWeb(int room, int state) {
  // Send JSON update string to web
  String output = "{";
  output += "\"" + String(ledPins[room]) + "\":\"" + (state == HIGH ? "1" : "0") + "\"";
  output += "}";
  Serial.println(output);
}
