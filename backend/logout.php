<?php
session_start();
require_once '../dB/conn.php';

if (isset($_SESSION['user'])) {
    $mem_id = $_SESSION['user'];
    $sqlUpdateStatus = "UPDATE `member` SET `status`='inactive' WHERE `mem_id`=?";
    $stmt = $conn->prepare($sqlUpdateStatus);
    $stmt->execute([$mem_id]);

    unset($_SESSION['user']);
    $_SESSION['message'] = array("text" => "You have successfully logged out!", "alert" => "info");
}

header('location: ../index.php');
?>
