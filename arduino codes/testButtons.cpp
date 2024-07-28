// Constants won't change. They're used here to set pin numbers:
const int buttonPins[] = {8, 12, 13};  // the numbers of the pushbutton pins
const int ledPins[] = {5, 6, 10};  // the numbers of the LED pins


// Variables will change:
int ledStates[] = {LOW, LOW, LOW};   // variables for storing the LED states
int buttonStates[3];                 // variables for reading the pushbutton statuses
int lastButtonStates[] = {HIGH, HIGH, HIGH};  // variables for the previous button states

void setup() {
  // Initialize the LED pins as outputs:
  for (int i = 0; i < 3; i++) {
    pinMode(ledPins[i], OUTPUT);
    // Initialize the pushbutton pins as inputs with pullup resistors:
    pinMode(buttonPins[i], INPUT_PULLUP);
  }
}

void loop() {
  // Loop through each button:
  for (int i = 0; i < 3; i++) {
    // Read the pushbutton input pin:
    buttonStates[i] = digitalRead(buttonPins[i]);

    // Check if the button state has changed
    if (buttonStates[i] != lastButtonStates[i]) {
      // If the button is pressed
      if (buttonStates[i] == LOW) {
        // Toggle the LED state
        ledStates[i] = !ledStates[i];
        // Update the LED with the new state
        digitalWrite(ledPins[i], ledStates[i]);
      }
      // Small delay to debounce button
      delay(50);
    }

    // Save the current button state
    lastButtonStates[i] = buttonStates[i];
  }
}
