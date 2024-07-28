<?php
// This file updates the state (0/1) and timestamp in the database based on user input in home.php

require '../dB/conn.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $data = file_get_contents('php://input');
    $json = json_decode($data, true);

    if ($json !== null) {
        try {
            // Prepare the SQL update statement
            $sql = "UPDATE states SET state = :state, last_updated = CURRENT_TIMESTAMP WHERE room = :room";
            $stmt = $conn->prepare($sql);

            // Loop through each switch state and update the database
            foreach ($json as $pin => $state) {
                $room = 0;
                switch ($pin) {
                    case '8':
                        $room = 1;
                        break;
                    case '12':
                        $room = 2;
                        break;
                    case '13':
                        $room = 4;
                        break;
                    default:
                        continue; // Skip invalid pin values
                }
                $state = intval($state);

                // Bind parameters
                $stmt->bindParam(':room', $room, PDO::PARAM_INT);
                $stmt->bindParam(':state', $state, PDO::PARAM_INT);

                // Execute the statement
                $stmt->execute();
            }

            echo json_encode(['success' => true, 'message' => 'Status updated successfully.']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid JSON data.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
