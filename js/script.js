document.addEventListener('DOMContentLoaded', () => {
    const containers = document.querySelectorAll('.icon-container');
    
    containers.forEach(container => {
        if (!container.getAttribute('data-status')) {
            container.setAttribute('data-status', 'off');
        }
        
        container.addEventListener('click', () => {
            const isOff = container.getAttribute('data-status') === 'off';
            container.setAttribute('data-status', isOff ? 'on' : 'off');
            container.querySelector('.status-text').textContent = isOff ? 'ON' : 'OFF';
            
            const status = isOff ? 'ON' : 'OFF';
            const itemName = container.querySelector('p').textContent;
            addNotification(`${itemName} turned ${status}`);
        });
    });

    function addNotification(message) {
        const notifications = JSON.parse(localStorage.getItem('notifications')) || [];
        const timestamp = new Date().toLocaleString();
        notifications.push({ message, timestamp });
        localStorage.setItem('notifications', JSON.stringify(notifications));
    }
});
