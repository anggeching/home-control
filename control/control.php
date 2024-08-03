<?php
require '../dB/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room = $_POST['room'];
    $state = $_POST['state'] === 'on' ? 1 : 0;

    $query = "UPDATE states SET state = :state WHERE room = :room";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':state', $state);
    $stmt->bindParam(':room', $room);

    if ($stmt->execute()) {
        echo "Room $room state updated to $state";
    } else {
        echo "Failed to update room $room state";
    }
}
?>
