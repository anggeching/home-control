function toggleDevice(device) {
    const statusElement = document.getElementById(`${device}-status`);
    let currentStatus = statusElement.innerText.split(': ')[1];
    
    if (currentStatus === 'Off' || currentStatus === 'Locked') {
        statusElement.innerText = device.includes('door-lock') ? 'Status: Unlocked' : 'Status: On';
    } else {
        statusElement.innerText = device.includes('door-lock') ? 'Status: Locked' : 'Status: Off';
    }

    console.log(`${device} toggled`);
}

// Mock data to demonstrate functionality
document.getElementById('room-status').innerText = "Room 1: Someone is in the room";
document.getElementById('brightness-status').innerText = "Outside Brightness: 80%";
document.getElementById('temperature-status').innerText = "Temperature in Sala: 27°C";
