<?php
    session_start();

    // Redirects to home page if the user logged in
    if(isset($_SESSION["username"])) {
        header("Location: home.php");
        exit();
    }

    // Checks for previous login error messages
    $error = isset($_GET['error']) ? $_GET['error'] : '';

    // Displays error messages
    if ($error === 'empty') {
        $errorMessage = "Please fill in all fields.";
    } elseif ($error === 'invalid') {
        $errorMessage = "Invalid username or password.";
    } else {
        $errorMessage = "";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SwiftNotes - Login Page</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-teal">

    <div class="w3-light-grey w3-content w3-panel w3-card-4 w3-padding w3-round-large" style="max-width: 400px">
        <h1 class="w3-center">Login to SwiftNotes</h1>

        <!-- Display error messages if any -->
        <?php if ($errorMessage !== ""): ?>
            <div class="w3-panel w3-red">
                <p><?php echo $errorMessage; ?></p>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="server.php" method="post" class="w3-container">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" class="w3-input w3-border w3-round" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="w3-input w3-border w3-round" required>
            <br>
            <button type="Submit" class="w3-button w3-round-large w3-blue">Login</button>
        </form>

        <!-- Redirects  to register page -->
        <div class="w3-margin-top">
            Don't have an account? <a href="register.php" class="w3-text-blue">Register here</a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="w3-container w3-center w3-bottom w3-padding w3-margin-top">
        &copy; 2023 Gavin Boyles
    </footer>

</body>
</html>
