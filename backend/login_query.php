<?php
session_start();
require_once '../dB/conn.php';

if (isset($_POST['login'])) {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];


        $sql = "SELECT * FROM member WHERE username=? AND password=?";
        $query = $conn->prepare($sql);
        $query->execute([$username, $password]);
        $row = $query->rowCount();
        $fetch = $query->fetch();


        if ($row > 0) {
            $_SESSION['user'] = $fetch['mem_id'];


            $sqlUpdateStatus = "UPDATE member SET status='active' WHERE mem_id=?";
            $stmt = $conn->prepare($sqlUpdateStatus);
            $stmt->execute([$fetch['mem_id']]);

            echo "<script>
                    alert('Login successful!');
                    window.location.href = '../front-end/home.php';
                  </script>";
        } else {
            // Debugging statement: Login failed
            echo "<script>
                    alert('Login failed!');
                    window.location.href = '../index.php';
                  </script>";
        }
    } else {
        // Debugging statement: Username or password field empty
        echo "<script>
                alert('Username or Password field is empty!');
                window.location.href = '../index.php';
              </script>";
    }
}
?>
