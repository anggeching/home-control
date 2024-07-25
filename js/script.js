document.addEventListener('DOMContentLoaded', function() {
    const fanIcon = document.getElementById('fan-icon');
    const fanStatus = document.getElementById('fan-status');
    
    fanIcon.addEventListener('click', function() {
        fanIcon.classList.toggle('active');
        if (fanIcon.classList.contains('active')) {
            fanStatus.textContent = 'Status: On';
        } else {
            fanStatus.textContent = 'Status: Off';
        }
    });
});