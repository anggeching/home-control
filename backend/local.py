import requests
import time
import serial
import json

# Set up the serial connection to the Arduino
ser = serial.Serial('COM3', 9600)  # Update to your COM port

def get_light_states():
    try:
        response = requests.get('http://localhost/home-control/dB/states.php')
        response.raise_for_status()  # Raise an error for bad HTTP responses
        print(f"Response Text: {response.text}")  # Debugging line
        return response.json()
    except requests.exceptions.RequestException as e:
        print(f"HTTP Request failed: {e}")
        return []
    except ValueError as e:
        print(f"JSON decoding failed: {e}")
        return []

def update_slide_switch_states(states):
    url = 'http://localhost/home-control/control/control.php'
    try:
        response = requests.post(url, json=states)
        response.raise_for_status()  # Raise an error for bad HTTP responses
        print(f"Switch states updated: {states}")
    except requests.exceptions.RequestException as e:
        print(f"HTTP Request failed: {e}")

def read_slide_switch():
    while ser.in_waiting:
        line = ser.readline().decode().strip()
        if line.startswith("{") and line.endswith("}"):
            try:
                states = json.loads(line)  # Parse the JSON string
                print(f"Read from Arduino: {states}")
                update_slide_switch_states(states)
            except json.JSONDecodeError as e:
                print(f"JSON decoding failed: {e}")

def control_arduino(room, state):
    ser.write(f'{room}:{state}\n'.encode())

def main():
    while True:
        light_states = get_light_states()
        for state_info in light_states:
            room = state_info['room']
            state = state_info['state']
            control_arduino(room, state)
        read_slide_switch()
        time.sleep(0.1)  # Small delay to prevent overwhelming the serial buffer

if __name__ == "__main__":
    main()
