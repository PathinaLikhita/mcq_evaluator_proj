<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get POST data safely
$email = htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES);
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    die('<script>alert("Email and password are required."); window.history.back();</script>');
}

// Connect to database
$conn = new mysqli('localhost', 'root', '', 'mcq_evaluator');
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

// Prepare SELECT statement
$stmt = $conn->prepare("SELECT id, email, password FROM register WHERE email = ?");
if (!$stmt) {
    die('Error preparing SELECT statement: ' . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();

// Use bind_result and fetch to avoid get_result issues
$stmt->bind_result($id, $email_db, $hashed_password);

if ($stmt->fetch()) {
    // User found, verify password
    if (password_verify($password, $hashed_password)) {
        echo "<script>alert('Login successful!');</script>";

        // Record login email and current timestamp into login table
        $loginStmt = $conn->prepare("INSERT INTO login (email, login_time) VALUES (?, NOW())");
        if (!$loginStmt) {
            die('Error preparing INSERT statement: ' . $conn->error);
        }

        $loginStmt->bind_param("s", $email);
        if ($loginStmt->execute()) {
            echo "<script>alert('Login details recorded successfully.');</script>";
            // Redirect or further logic here
        } else {
            die('Error inserting login details: ' . $loginStmt->error);
        }

        $loginStmt->close();
    } else {
        echo "<script>alert('Invalid password. Please try again.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('No account found. Please register first.'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
