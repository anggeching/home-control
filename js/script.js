document.addEventListener('DOMContentLoaded', () => {
    const containers = document.querySelectorAll('.icon-container');
  
    containers.forEach(container => {
      container.addEventListener('click', () => {
        const isOff = container.getAttribute('data-status') === 'off';
        container.setAttribute('data-status', isOff ? 'on' : 'off');
        container.querySelector('.status-text').textContent = isOff ? 'ON' : 'OFF';
      });
    });
  });