<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$fname = htmlspecialchars($_POST['fname'] ?? '', ENT_QUOTES);
$lname = htmlspecialchars($_POST['lname'] ?? '', ENT_QUOTES);
$email = htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES);
$password = $_POST['password'] ?? '';
$mobileNumber = htmlspecialchars($_POST['mobileNumber'] ?? '', ENT_QUOTES);

if (empty($fname) || empty($lname) || empty($email) || empty($password) || empty($mobileNumber)) {
    die('<script>alert("All fields are required.");</script>');
}

$conn = new mysqli('localhost', 'root', '', 'mcq_evaluator');

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

// Check if the email already exists
$stmt = $conn->prepare("SELECT email FROM register WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('You are already registered. Please log in.');</script>";
} else {
    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO register (fname, lname, email, password, mobileNumber) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die('Error preparing statement: ' . $conn->error);
    }

    $stmt->bind_param("sssss", $fname, $lname, $email, $hashedPassword, $mobileNumber);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! You can now log in.');</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>
