<!DOCTYPE html>
<?php
    require '../dB/conn.php'; // connecting to dB
    session_start(); 
    // Fetch the username from the session
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Unknown'; // Retrieve username from session
?>
<html lang="en">
<head>
    <title>Home Control</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav>
    <h2>Home Automation</h2>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="control.php">Control Logs</a></li>
            <li><a href="../backend/logout.php">Logout</a></li>
        </ul>
    </nav>
      
    <header class="header-text">
        <h1>Current Status</h1>
    </header>

    <section class="icons-section">
        <div class="icon-container">
            <!-- Motion Sensor Icon -->
            <img class="icon icon-motion-sensor" src="../assets/img/walk.png" alt="Motion Sensor">
            <p>Motion Sensor</p>
        </div>
        <div class="icon-container">
            <!-- Outdoor Light Icon -->
            <img class="icon icon-light" src="../assets/img/outdoor.png" alt="Light Dependent Resistor">
            <p>Outdoor Light</p>
        </div>
        <div class="icon-container">
            <!-- Temperature Icon -->
            <img class="icon icon-temperature" src="../assets/img/temperature.png" alt="Temperature">
            <p>Temperature</p>
        </div>
    </section>

    <!-- New Section: Home Control -->
    <header class="header-text">
        <h1>Home Control</h1>
    </header>

    <section class="icons-section grid-2x2">
        <!-- Icon Containers (Static HTML) -->
        <!-- Note: The data-room attributes should match the IDs in the database -->
        <div class="icon-container" data-room="1"> 
            <img class="icon icon-example-2" src="../assets/img/livingroom.png" alt="Living Room Light">
            <p>Living Room Light</p>
            <div class="status-wrapper">
              <span class="status-indicator"></span>
              <p class="status-text">OFF</p>
          </div>
        </div>
        <div class="icon-container" data-room="2">
            <img class="icon icon-example-3" src="../assets/img/bedroomlight.png" alt="Bedroom Light">
            <p>Bedroom Light</p>
            <div class="status-wrapper">
              <span class="status-indicator"></span>
              <p class="status-text">OFF</p>
          </div>
        </div>
        <div class="icon-container" data-room="4">
            <img class="icon icon-example-5" src="../assets/img/fan.png" alt="Fan">
            <p>Fan</p>
            <div class="status-wrapper">
              <span class="status-indicator"></span>
              <p class="status-text">OFF</p>
          </div>
        </div>
        <div class="icon-container" data-room="3">
            <img class="icon icon-example-4" src="../assets/img/cabinet.png" alt="Cabinet">
            <p>Cabinet</p>
            <div class="status-wrapper">
              <span class="status-indicator"></span>
              <p class="status-text">OFF</p>
          </div>
        </div>
    </section>

        <!-- Pass the username to JavaScript -->
        <script>
        const username = '<?php echo $username; ?>';
    </script>

    <script src="../js/script.js"></script>
    <script>
        // Fetch the current states and update the UI
        fetch('../dB/states.php')
            .then(response => response.json())
            .then(data => {
                document.querySelectorAll('.icon-container').forEach(container => {
                    const room = container.getAttribute('data-room');
                    if (data[room]) {
                        const { state, name } = data[room];
                        container.querySelector('.status-text').textContent = state === 1 ? 'ON' : 'OFF';
                        container.setAttribute('data-status', state === 1 ? 'on' : 'off');
                        container.classList.toggle('active', state === 1);
                    }
                });
            })
            .catch(error => console.error('Error fetching states:', error));
    </script>
</body>
</html>