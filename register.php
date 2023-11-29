<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("db_connect.php");

    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    // Validate input
    if (empty($username) || empty($password) || empty($confirmPassword)) {
        header("Location: register.php?error=empty");
        exit();
    }

    // Checks if password and confirm password match
    if ($password !== $confirmPassword) {
        header("Location: register.php?error=password_mismatch");
        exit();
    }

    // Hashes password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Checks if username is taken
    $checkUsernameSql = "SELECT COUNT(*) FROM users WHERE username = :username";
    $checkUsernameStmt = $pdo->prepare($checkUsernameSql);
    $checkUsernameStmt->bindParam(':username', $username);
    $checkUsernameStmt->execute();
    $count = $checkUsernameStmt->fetchColumn();

    if ($count > 0) {
        // Redirect with an error message for duplicate username
        header("Location: register.php?error=duplicate");
        exit();
    }

    // Inserts user into database
    $insertUserSql = "INSERT INTO users (username, password) VALUES (:username, :password)";
    $insertUserStmt = $pdo->prepare($insertUserSql);
    $insertUserStmt->bindParam(':username', $username);
    $insertUserStmt->bindParam(':password', $hashedPassword);

    try {
        $insertUserStmt->execute();
        header("Location: login.php?register=success");
        exit();
    } catch (PDOException $e) {
        // Handle other errors, if necessary
        header("Location: register.php?error=unknown");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SwiftNotes - Registration Page</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-teal">

    <div class="w3-light-grey w3-content w3-panel w3-card-4 w3-padding w3-round-large" style="max-width: 400px">
        <h1 class="w3-center">Register an Account</h1>

        <!-- Displays error message -->
        <?php if (isset($_GET['error'])): ?>
            <div class="w3-panel w3-red">
                <?php if ($_GET['error'] === 'duplicate'): ?>
                    <p>Username is already taken. Please choose another one.</p>
                <?php elseif ($_GET['error'] === 'password_mismatch'): ?>
                    <p>Password and confirm password do not match.</p>
                <?php else: ?>
                    <p>An unknown error occurred.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

         <!-- Register form -->
        <form action="register.php" method="post" class="w3-container">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" class="w3-input w3-border w3-round" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="w3-input w3-border w3-round" required>
            <br>
            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" class="w3-input w3-border w3-round" required>
            <br>
            <button type="Submit" class="w3-button w3-round-large w3-green">Register</button>
        </form>

        <!-- Redirects  to login page -->
        <div class="w3-margin-top">
            Already have an account? <a href="login.php" class="w3-text-blue">Login here</a>
        </div>
    </div>

     <!-- Footer -->
    <footer class="w3-container w3-center w3-bottom w3-padding w3-margin-top">
        &copy; 2023 Gavin Boyles
    </footer>

</body>
</html>
