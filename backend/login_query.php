<?php
session_start();
require_once '../dB/conn.php';

if (isset($_POST['login'])) {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql = "SELECT * FROM `member` WHERE `username`=? AND `password`=?";
        $query = $conn->prepare($sql);
        $query->execute([$username, $password]);
        $row = $query->rowCount();
        $fetch = $query->fetch();

        if ($row > 0) {
            $_SESSION['user'] = $fetch['mem_id'];
            $sqlUpdateStatus = "UPDATE `member` SET `status`='active' WHERE `mem_id`=?";
            $stmt = $conn->prepare($sqlUpdateStatus);
            $stmt->execute([$fetch['mem_id']]);

            $_SESSION['message'] = array("text" => "Login successful.", "alert" => "success");
            header("location: ../front-end/home.php");
        } else {
            $_SESSION['message'] = array("text" => "Invalid username or password.", "alert" => "danger");
            header("location: ../index.php");
        }
    } else {
        $_SESSION['message'] = array("text" => "Please complete the required fields.", "alert" => "danger");
        header("location: ../index.php");
    }
}
?>
