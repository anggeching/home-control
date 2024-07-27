<?php
// This file updates the state (0/1) and timestamp in the database based on slide switch (hardware)

require '../dB/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['switch_state'])) {
    $switch_state = $_POST['switch_state'] === 'on' ? 1 : 0; // Convert 'on' to 1 and 'off' to 0
    $timestamp = date('Y-m-d H:i:s');

    try {
        // Update the state and timestamp for the room with id 1
        $stmt = $conn->prepare("UPDATE states SET state = :state, timestamp = :timestamp WHERE room = 1");
        $stmt->bindParam(':state', $switch_state);
        $stmt->bindParam(':timestamp', $timestamp);
        $stmt->execute();
        echo "Switch state updated successfully";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Required parameters missing.";
}
?>
