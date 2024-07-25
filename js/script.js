document.addEventListener('DOMContentLoaded', () => {
    const containers = document.querySelectorAll('.icon-container');
    
    containers.forEach(container => {
        // Initialize the data-status attribute if it doesn't exist
        if (!container.getAttribute('data-status')) {
            container.setAttribute('data-status', 'off');
        }
        
        container.addEventListener('click', () => {
            const isOff = container.getAttribute('data-status') === 'off';
            container.setAttribute('data-status', isOff ? 'on' : 'off');
            container.querySelector('.status-text').textContent = isOff ? 'ON' : 'OFF';
        });
    });
});


