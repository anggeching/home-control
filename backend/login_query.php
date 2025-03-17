<?php
session_start();

if (isset($_POST['login'])) {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        // Hardcoded credentials for login
        if ($username === 'admin' && $password === 'admin') {
            session_regenerate_id(true);
            $_SESSION['admin'] = true;
            $_SESSION['username'] = $username;

            echo "<script>
                    alert('Admin login successful!');
                    window.location.href = '../front-end/home.php';
                  </script>";
            exit();
        } else {
            echo "<script>
                    alert('Invalid credentials!');
                    window.location.href = '../index.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Username or Password field is empty!');
                window.location.href = '../index.php';
              </script>";
    }
}
?>
