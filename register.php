<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get POST data safely
    $fname = htmlspecialchars($_POST['fname'] ?? '', ENT_QUOTES);
    $lname = htmlspecialchars($_POST['lname'] ?? '', ENT_QUOTES);
    $email = htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES);
    $password = $_POST['password'] ?? '';
    $mobileNumber = htmlspecialchars($_POST['mobileNumber'] ?? '', ENT_QUOTES);

    if (empty($fname) || empty($lname) || empty($email) || empty($password) || empty($mobileNumber)) {
        die('<script>alert("All fields are required."); window.history.back();</script>');
    }

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'quiz_proj');
    if ($conn->connect_error) {
        die('Database connection failed: ' . $conn->connect_error);
    }

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT email FROM register WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('You are already registered. Please log in.'); window.location.href='login.php';</script>";
    } else {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user details into the register table
        $stmt = $conn->prepare("INSERT INTO register (fname, lname, email, password, mobileNumber) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            die('Error preparing INSERT statement: ' . $conn->error);
        }

        $stmt->bind_param("sssss", $fname, $lname, $email, $hashedPassword, $mobileNumber);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful! Redirecting to login.'); window.location.href='login.php';</script>";
        } else {
            die('Error inserting user details: ' . $stmt->error);
        }
    }

    $stmt->close();
    $conn->close();
} else {
    // If accessed directly, do nothing or redirect
    header("Location: register.html");
    exit;
}
?>
