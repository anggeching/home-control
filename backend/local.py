import requests
import time
import serial
import json

# Set up the serial connection to the Arduino
ser = serial.Serial('COM4', 9600)  # Update to your COM port

def get_light_states():
    try:
        response = requests.get('http://localhost/home-control/dB/states.php')
        response.raise_for_status()  # Raise an error for bad HTTP responses
        return response.json()
    except requests.exceptions.RequestException as e:
        print(f"HTTP Request failed: {e}")
        return []
    except ValueError as e:
        print(f"JSON decoding failed: {e}")
        return []

def update_slide_switch_states(room):
    url = 'http://localhost/home-control/control/hardware_control.php'
    try:
        response = requests.post(url, json={"room": room, "toggle": True})
        response.raise_for_status()  # Raise an error for bad HTTP responses
        print(f"Switch state toggled for room: {room}")
    except requests.exceptions.RequestException as e:
        print(f"HTTP Request failed: {e}")

def read_slide_switch():
    while ser.in_waiting:
        line = ser.readline().decode().strip()
        if line.startswith("{") and line.endswith("}"):
            try:
                states = json.loads(line)  # Parse the JSON string
                print(f"Read from Arduino: {states}")
                room = states.get("room")
                if room is not None:
                    update_slide_switch_states(room)
            except json.JSONDecodeError as e:
                print(f"JSON decoding failed: {e}")

def update_database(room, state):
    url = 'http://localhost/home-control/dB/states.php'
    data = {'room': room, 'state': state}
    try:
        response = requests.post(url, data=data)
        response.raise_for_status()  # Raise an error for bad HTTP responses
        print(f"Successfully updated database for room {room} with state {state}")
    except requests.exceptions.RequestException as e:
        print(f"Failed to update database for room {room}: {e}")

def control_arduino(room, state):
    # Map room to corresponding LED pin on Arduino
    room_to_pin = {
        1: 5,
        2: 6,
        4: 10,
        5: 11
    }
    if room in room_to_pin:
        pin = room_to_pin[room]
        ser.write(f'{pin}:{state}\n'.encode())
        print(f"Sent to Arduino: pin {pin}, state {state}")

def read_sensor_data():
    try:
        if ser.in_waiting > 0:
            line = ser.readline().decode('utf-8').strip()
            if line.startswith("{") and line.endswith("}"):  # Check if line is JSON
                try:
                    data = json.loads(line)
                    temperature = data.get("temperature")
                    ir_detected = data.get("motionDetected")
                    light = data.get("light")
                    light_status = data.get("lightStatus")

                    # Process sensor data
                    print(f"Temperature: {temperature} °C, IR Sensor: {'Someone is detected' if ir_detected else 'No motion detected'}, Light Level: {light}, Light Status: {'ON' if light_status else 'OFF'}")

                    # Save sensor data to JSON file
                    with open('./sensor_data.json', 'w') as f:  # Updated relative path to parent directory
                        json.dump(data, f)

                except json.JSONDecodeError:
                    # Handle JSON decoding error silently
                    pass
    except Exception:
        # Handle general exception silently
        pass

def main():
    while True:
        read_sensor_data()  # Call the sensor reading function
        light_states = get_light_states()
        for state_info in light_states:
            room = state_info.get('room')
            state = state_info.get('state')
            if room is not None and state is not None:
                control_arduino(room, state)
        read_slide_switch()
        time.sleep(0.1)  # Small delay to prevent overwhelming the serial buffer

if __name__ == "__main__":
    main()
import requests
import time
import serial
import json

# Set up the serial connection to the Arduino
ser = serial.Serial('COM4', 9600)  # Update to your COM port

def get_light_states():
    try:
        response = requests.get('http://localhost/home-control/dB/states.php')
        response.raise_for_status()  # Raise an error for bad HTTP responses
        return response.json()
    except requests.exceptions.RequestException as e:
        print(f"HTTP Request failed: {e}")
        return []
    except ValueError as e:
        print(f"JSON decoding failed: {e}")
        return []

def update_slide_switch_states(room):
    url = 'http://localhost/home-control/control/hardware_control.php'
    try:
        response = requests.post(url, json={"room": room, "toggle": True})
        response.raise_for_status()  # Raise an error for bad HTTP responses
        print(f"Switch state toggled for room: {room}")
    except requests.exceptions.RequestException as e:
        print(f"HTTP Request failed: {e}")

def read_slide_switch():
    while ser.in_waiting:
        line = ser.readline().decode().strip()
        if line.startswith("{") and line.endswith("}"):
            try:
                states = json.loads(line)  # Parse the JSON string
                print(f"Read from Arduino: {states}")
                room = states.get("room")
                if room is not None:
                    update_slide_switch_states(room)
            except json.JSONDecodeError as e:
                print(f"JSON decoding failed: {e}")

def update_database(room, state):
    url = 'http://localhost/home-control/dB/states.php'
    data = {'room': room, 'state': state}
    try:
        response = requests.post(url, data=data)
        response.raise_for_status()  # Raise an error for bad HTTP responses
        print(f"Successfully updated database for room {room} with state {state}")
    except requests.exceptions.RequestException as e:
        print(f"Failed to update database for room {room}: {e}")

def control_arduino(room, state):
    # Map room to corresponding LED pin on Arduino
    room_to_pin = {
        1: 5,
        2: 6,
        4: 10,
        5: 11
    }
    if room in room_to_pin:
        pin = room_to_pin[room]
        ser.write(f'{pin}:{state}\n'.encode())
        print(f"Sent to Arduino: pin {pin}, state {state}")

def read_sensor_data():
    try:
        if ser.in_waiting > 0:
            line = ser.readline().decode('utf-8').strip()
            if line.startswith("{") and line.endswith("}"):  # Check if line is JSON
                try:
                    data = json.loads(line)
                    temperature = data.get("temperature")
                    ir_detected = data.get("irDetected")
                    light = data.get("light")
                    light_status = data.get("lightStatus")

                    # Process sensor data
                    print(f"Temperature: {temperature} °C, IR Sensor: {'Someone is detected' if ir_detected else 'No motion detected'}, Light Level: {light}, Light Status: {'ON' if light_status else 'OFF'}")

                    # Save sensor data to JSON file
                    with open('./sensor_data.json', 'w') as f:  # Updated relative path to parent directory
                        json.dump(data, f)

                except json.JSONDecodeError:
                    # Handle JSON decoding error silently
                    pass
    except Exception:
        # Handle general exception silently
        pass

def main():
    while True:
        read_sensor_data()  # Call the sensor reading function
        light_states = get_light_states()
        for state_info in light_states:
            room = state_info.get('room')
            state = state_info.get('state')
            if room is not None and state is not None:
                control_arduino(room, state)
        read_slide_switch()
        time.sleep(0.1)  # Small delay to prevent overwhelming the serial buffer

if __name__ == "__main__":
    main()
