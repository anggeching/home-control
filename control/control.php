<?php
// This file handles both user actions and hardware updates to control the state (0/1) and timestamp in the database

require '../dB/conn.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $data = file_get_contents('php://input');
    $json = json_decode($data, true);

    // Check if the request is from hardware (JSON) or manual input (form data)
    if ($json !== null) {
        try {
            // Prepare the SQL update statement
            $sql = "UPDATE states SET state = :state, last_updated = CURRENT_TIMESTAMP WHERE room = :room";
            $stmt = $conn->prepare($sql);

            // Debug: Print received JSON data
            error_log("Received JSON data: " . print_r($json, true));

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
                        error_log("Invalid pin: $pin");
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
    } else if (isset($_POST['room']) && isset($_POST['state'])) {
        // Handle manual input from the web interface
        $room = intval($_POST['room']);
        $state = $_POST['state'] === 'on' ? 1 : 0;

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
        echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
