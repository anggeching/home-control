const int switchPins[] = {8, 12, 13}; // Pins connected to the slide switches
int switchStates[3] = {0, 0, 0};     // Array to hold the current state of each switch
int lastSwitchStates[3] = {0, 0, 0}; // Array to hold the last state of each switch

void setup() {
  for (int i = 0; i < 3; i++) {
    pinMode(switchPins[i], INPUT_PULLUP); // Set the slide switch pins as input with internal pull-up resistors
  }
  Serial.begin(9600); // Initialize serial communication
}

void loop() {
  // Read the state of each switch and check if it has changed
  for (int i = 0; i < 3; i++) {
    switchStates[i] = digitalRead(switchPins[i]);
    
    if (switchStates[i] != lastSwitchStates[i]) {
      // Create JSON string
      String output = "{";
      for (int j = 0; j < 3; j++) {
        if (j > 0) output += ",";
        output += "\"" + String(switchPins[j]) + "\":\"" + (switchStates[j] == LOW ? "1" : "0") + "\"";
      }
      output += "}";
      Serial.println(output);
      delay(50); // Debounce delay
    }
    
    // Save the current state as the last state
    lastSwitchStates[i] = switchStates[i];
  }
  
  delay(10); // Small delay for stability
}
