import requests
import time
import serial
import json

# Set up the serial connection to the Arduino
ser = serial.Serial('COM3', 9600)  # Update to your COM port

def update_slide_switch_states(states):
    url = 'http://localhost/home-control/control/mancontrol.php'
    try:
        # Debugging: Print the data being sent
        print(f"Sending data to webcontrol.php: {states}")
        response = requests.post(url, json=states)
        response.raise_for_status()  # Raise an error for bad HTTP responses
        print(f"Switch states updated: {states}")
    except requests.exceptions.RequestException as e:
        print(f"HTTP Request failed: {e}")

def read_slide_switch():
    # Reads data from Arduino
    while ser.in_waiting:
        line = ser.readline().decode().strip()
        if line.startswith("{") and line.endswith("}"):
            try:
                states = json.loads(line)  # Parse the JSON string
                # Debugging: Print the switch states read from Arduino
                print(f"Read from Arduino: {states}")
                update_slide_switch_states(states)
            except json.JSONDecodeError as e:
                print(f"JSON decoding failed: {e}")

def main():
    while True:
        read_slide_switch()
        time.sleep(0.1)  # Small delay to prevent overwhelming the serial buffer

if __name__ == "__main__":
    main()
