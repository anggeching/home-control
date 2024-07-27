import requests
import time
import serial

# Set up the serial connection to the Arduino
ser = serial.Serial('COM3', 9600)  # Update to your COM port

def update_slide_switch_state(room, state):
    try:
        # Debugging: Print the data being sent
        print(f"Sending data to manual_control.php: room={room}, switch_state={state}")
        response = requests.post('http://localhost/home-control/control/manual_control.php', data={'room': room, 'switch_state': state})
        response.raise_for_status()  # Raise an error for bad HTTP responses
        print(f"Switch state updated for room {room}: {state}")
    except requests.exceptions.RequestException as e:
        print(f"HTTP Request failed: {e}")

def read_slide_switch():
    while ser.in_waiting:
        line = ser.readline().decode().strip()
        if line.startswith("ROOM:"):
            parts = line.split(", ")
            room = parts[0].split(":")[1]
            state = parts[1].split(":")[1]
            # Debugging: Print the switch state read from Arduino
            print(f"Read from Arduino: ROOM:{room}, STATE:{state}")
            update_slide_switch_state(room, state)

def main():
    last_state = {}  # To keep track of the last state for each room
    while True:
        if ser.in_waiting:
            line = ser.readline().decode().strip()
            if line.startswith("ROOM:"):
                parts = line.split(", ")
                room = parts[0].split(":")[1]
                state = parts[1].split(":")[1]
                if room not in last_state or state != last_state[room]:  # Only update if the state has changed
                    # Debugging: Print the new switch state read from Arduino
                    print(f"Switch state changed for room {room}: {state}")
                    update_slide_switch_state(room, state)
                    last_state[room] = state
        time.sleep(0.1)  # Small delay to prevent overwhelming the serial buffer

if __name__ == "__main__":
    main()
