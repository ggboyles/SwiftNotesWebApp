<?php
session_start();
include("db_connect.php");

// Check if the form is submitted to add a new note
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_note"])) {
    $title = $_POST["note_title"];
    $content = $_POST["note_content"];

    // Insert the new note into the database
    $sqlInsertNote = "INSERT INTO notes (user_id, title, content, timestamp) VALUES (:user_id, :title, :content, NOW())";
    $stmtInsertNote = $pdo->prepare($sqlInsertNote);
    $stmtInsertNote->bindParam(':user_id', $_SESSION['user_id']);
    $stmtInsertNote->bindParam(':title', $title);
    $stmtInsertNote->bindParam(':content', $content);
    $stmtInsertNote->execute();
}

// Gets user's notes from the database
$sql = "SELECT * FROM notes WHERE user_id = :user_id ";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle note deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_note"])) {
    $noteId = $_POST["note_id"];

    // Deletes note from the database
    $sqlDeleteNote = "DELETE FROM notes WHERE id = :note_id AND user_id = :user_id";
    $stmtDeleteNote = $pdo->prepare($sqlDeleteNote);
    $stmtDeleteNote->bindParam(':note_id', $noteId);
    $stmtDeleteNote->bindParam(':user_id', $_SESSION['user_id']);
    $stmtDeleteNote->execute();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SwiftNotes - Home</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-light-grey">

    <!-- Nav bar -->
    <div class="w3-bar w3-teal">
        <a href="#" class="w3-bar-item w3-button">Home</a>
        <a href="about.html" class="w3-bar-item w3-button">About</a>
        <a href="contact.html" class="w3-bar-item w3-button">Contact</a>
        <div class="w3-right">
            <a href="logout.php" class="w3-bar-item w3-button">Logout</a>
        </div>
    </div>

    <div class="w3-white w3-panel w3-content w3-margin-top w3-card-4 w3-round-large" style="max-width: 600px">
        <div class="w3-container w3-padding-16">
            <h1 class="w3-center">Welcome to SwiftNotes</h1>
            <p class="w3-larg w3-center w3-text-teal">Hello, <?php echo $_SESSION['username']; ?>!</p>
        </div>

        <!-- New note form -->
        <div class="w3-container w3-padding-16">
            <h2>Add a New Note</h2>
            <form action="home.php" method="post">
                <label for="note_title">Title:</label>
                <input type="text" id="note_title" name="note_title" class="w3-input w3-border" required>
                <br>
                <label for="note_content">Content:</label>
                <textarea id="note_content" name="note_content" class="w3-input w3-border" required></textarea>
                <br>
                <button type="submit" name="submit_note" class="w3-button w3-round-large w3-green">Add Note</button>
            </form>
        </div>

        <!-- Display user's notes -->
        <div class="w3-container w3-padding-16">
            <h2>Your Notes</h2>
            <ul class="w3-ul">
                <?php foreach ($notes as $note): ?>
                    <li>
                        <strong><?php echo $note['title']; ?></strong><br>
                        <?php echo $note['content']; ?><br>
                        <small><?php echo $note['timestamp']; ?></small>
                        <form action="home.php" method="post">
                            <input type="hidden" name="note_id" value="<?php echo $note['id']; ?>">
                            <button type="submit" name="delete_note" class="w3-button w3-round-large w3-light-gray">🗑️</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- Footer -->
    <footer class="w3-container w3-center w3-bottom w3-teal w3-padding w3-margin-top">
        &copy; 2023 Gavin Boyles
    </footer>

</body>
</html>
