3:19 PM
Chesca
Chesca Duatin
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartHome Control</title>
    <link rel="stylesheet" href="css/indexstyle.css">
</head>
<body>

    <div class="container">
        <h2>Home Automation</h2>
        <div class="buttons">
            <a class="button sign-up" href="#" id="signUpBtn">Sign Up</a>
            <a class="button log-in" href="#" id="logInBtn">Login</a>
        </div>
    </div>

    <?php if(isset($_SESSION['message'])): ?>
                <div class="alert alert-<?php echo $_SESSION['message']['alert'] ?> msg"><?php echo $_SESSION['message']['text'] ?></div>
                <script>
                    (function() {
                        setTimeout(function(){
                            document.querySelector('.msg').remove();
                        },3000)
                    })();
                </script>
            <?php 
                endif;
                unset($_SESSION['message']);
            ?>

    <div id="signUpForm" class="form-container">
        <form action="register_query.php" method="POST" id="signUpFormContent">
            <h3>SIGN UP</h3>
            <input type="text" placeholder="Name" name="name" required>
            <input type="email" placeholder="Email" name="email" required>
            <input type="password" placeholder="Password" name="password" required>
            <button type="submit">Sign Up</button>
        </form>
    </div>

    <div id="logInForm" class="form-container">
        <form action="../backend/login_query.php" method="POST" id="logInFormContent">

            <h3>LOGIN</h3>
            <input type="text" placeholder="Username" name = "username" required>
            <input type="password" placeholder="Password" name = "password" required>
            <button type="submit" >Login</button>
        </form>
    </div>

    <!-- Dialog Box -->
    <div id="dialogBox" class="dialog-box">
        <h3>Are you a:</h3>
        <button id="userBtn">User</button>
        <button id="adminBtn">Admin</button>
    </div>

    <script src="js/clickable.js"></script>
</body>
</html>