import requests
import time
import serial

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

def control_arduino(room, state):
    ser.write(f'{room}:{state}\n'.encode())

def reset_lights():
    # Send a reset command to the Arduino
    ser.write('RESET\n'.encode())
    print("Sent reset command to Arduino.")

def main():
    reset_lights()  # Reset all lights to off before starting

    previous_states = {}
    while True:
        light_states = get_light_states()
        for entry in light_states:
            room = entry['room']
            state = entry['state']
            if previous_states.get(room) != state:
                control_arduino(room, state)
                previous_states[room] = state
        time.sleep(1)

if __name__ == "__main__":
    main()
