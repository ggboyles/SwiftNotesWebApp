<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection code
    include("db_connect.php");

    // Get user input from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validates input
    if (empty($username) || empty($password)) {
        header("Location: login.php?error=empty");
        exit();
    }

    // Check user credentials in the database
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify password
    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Redirect to the home page
        header("Location: home.php");
        exit();
    } else {
        // Redirects back to the login page with an error message
        header("Location: login.php?error=invalid");
        exit();
    }
} else {

    header("Location: login.php");
    exit();
}
?>
