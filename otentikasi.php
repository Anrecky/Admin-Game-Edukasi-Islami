<?php
session_start();
include_once './config/database.php';
$database = new Database();
$db = $database->getConnection();
// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (!isset($_POST['username'], $_POST['password'])) {
    // Could not get the data that should have been sent.
    exit('Silahkan isi kolom username dan password!');
}
$stmt = $db->prepare("SELECT id, password FROM tbl_admin WHERE username = ?");
// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt) {
    // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
    $stmt->bindParam(1, $_POST['username']);
    $stmt->execute();
    // Store the result so we can check if the account exists in the database.
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() > 0) {
        if (password_verify($_POST['password'], $row['password'])) {
            // Verification success! User has logged-in!
            // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            header('Location: ./dashboard/pertanyaan.php');
        } else {
            // Incorrect password
            echo 'Username dan/atau password salah!';
        }
    } else {
        // Incorrect username
        echo 'Username dan/atau password salah!';
    }
}
