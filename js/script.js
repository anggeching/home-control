document.addEventListener('DOMContentLoaded', () => {
    const containers = document.querySelectorAll('.icon-container');

    containers.forEach(container => {
        // Initialize the data-status attribute if it doesn't exist
        if (!container.getAttribute('data-status')) {
            container.setAttribute('data-status', 'off');
        }

        container.addEventListener('click', () => {
            // Toggle the active class and update the data-status attribute
            const isOff = container.getAttribute('data-status') === 'off';
            const newState = isOff ? 'on' : 'off';
            container.setAttribute('data-status', newState);
            container.classList.toggle('active');

            // Update the status text based on the new state
            const statusText = isOff ? 'ON' : 'OFF';
            container.querySelector('.status-text').textContent = statusText;

            // Retrieve the data-room value
            const roomNumber = container.getAttribute('data-room');
            
            // Send data to control_lights.php
            fetch('../backend/control_lights.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'container=' + encodeURIComponent(roomNumber) + '&state=' + encodeURIComponent(newState)
            })
            .then(response => response.text())
            .then(data => {
                console.log(data); // Handle the response from the PHP script
            })
            .catch(error => {
                console.error('Error:', error);
            });

            // Add notification to local storage
            const itemName = container.querySelector('p').textContent;
            addNotification(`${itemName} turned ${statusText}`);
        });
    });

    function addNotification(message) {
        const notifications = JSON.parse(localStorage.getItem('notifications')) || [];
        const timestamp = new Date().toLocaleString();
        notifications.push({ message, timestamp });
        localStorage.setItem('notifications', JSON.stringify(notifications));
    }
});
