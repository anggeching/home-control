<!DOCTYPE html>
<?php
    // require '../dB/conn.php'; // Removed database connection
    session_start(); 

    /*
    if(!ISSET($_SESSION['user'])){ // Redirecting user to index if not logged in properly
        header('location:../index.php');
    }
    */
?>
<html lang="en">
<head>
    <title>SmartHome Control</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav>
    <h2>Home Automation</h2>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="notif.html">Notifications</a></li>
            <li><a href="../backend/logout.php">Logout</a></li>
        </ul>
    </nav>

    <header class="header-text">
        <h1>Current Status</h1>
    </header>

    <section class="icons-section">
        <div class="icon-container">
            <img class="icon icon-motion-sensor" src="../assets/img/walk.png" alt="Motion Sensor">
            <p>Motion Sensor: <span id="motion-sensor-status">N/A</span></p>
        </div>
        <div class="icon-container">
            <img class="icon icon-light" src="../assets/img/outdoor.png" alt="Light Dependent Resistor">
            <p>Outdoor Light: <span id="light-status">N/A</span></p>
        </div>
        <div class="icon-container">
            <img class="icon icon-temperature" src="../assets/img/temperature.png" alt="Temperature">
            <p>Temperature: <span id="temperature-value">N/A</span> °C</p>
        </div>
    </section>

    <header class="header-text">
        <h1>Home Control</h1>
    </header>

    <section class="icons-section grid-2x2">
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
        <div class="icon-container" data-room="5">
            <img class="icon icon-example-4" src="../assets/img/cabinet.png" alt="Cabinet">
            <p>Cabinet</p>
            <div class="status-wrapper">
              <span class="status-indicator"></span>
              <p class="status-text">OFF</p>
          </div>
        </div>
    </section>

    <script src="../js/script.js"></script>
</body>
</html>
