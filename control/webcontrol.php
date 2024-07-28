<?php
// this file update state (0/1) of  and time stamp in database based on user input in home.php



require '../dB/conn.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Check if the necessary POST parameters are set
    if (isset($_POST['room']) && isset($_POST['state'])) {
        // Retrieve the POST parameters
        $room = intval($_POST['room']);
        $state = $_POST['state'] === 'on' ? 1 : 0; // Convert 'on' to 1 and 'off' to 0

        try {
            // Prepare the SQL update statement
            $sql = "UPDATE states SET state = :state, last_updated = CURRENT_TIMESTAMP WHERE room = :room";
            $stmt = $conn->prepare($sql);
            
            // Bind parameters
            $stmt->bindParam(':room', $room, PDO::PARAM_INT);
            $stmt->bindParam(':state', $state, PDO::PARAM_INT);
            
            // Execute the statement
            if ($stmt->execute()) {
                echo "Status updated successfully.";
            } else {
                echo "Failed to update status.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Required parameters missing.";
    }
} else {
    echo "Invalid request method.";
}
?>
