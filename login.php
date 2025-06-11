<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get POST data safely
    $email = htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES);
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        die('<script>alert("Email and password are required."); window.history.back();</script>');
    }

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'quiz_proj');
    if ($conn->connect_error) {
        die('Database connection failed: ' . $conn->connect_error);
    }

    // Prepare SELECT statement
    $stmt = $conn->prepare("SELECT id, fname, lname, email, password FROM register WHERE email = ?");
if (!$stmt) {
    die('Error preparing SELECT statement: ' . $conn->error);
}


    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $fname, $lname, $email_db, $hashed_password);


    if ($stmt->fetch()) {
        // User found, verify password
        if (password_verify($password, $hashed_password)) {
            // Successful login
            echo "<script>alert('Login successful!');</script>";

            // Record login details
            $stmt->close();  // Close previous stmt before preparing a new one
            $loginStmt = $conn->prepare("INSERT INTO login (email, login_time) VALUES (?, NOW())");
            if (!$loginStmt) {
                die('Error preparing INSERT statement: ' . $conn->error);
            }

            $loginStmt->bind_param("s", $email);
            if ($loginStmt->execute()) {
                // Redirect to subjectselection.html
                echo "<script>
localStorage.setItem('registeredName', '$fname $lname');
localStorage.setItem('email', '$email');
window.location.href = 'Subject_selection.html';
</script>";

                exit();
            } else {
                die('Error inserting login details: ' . $loginStmt->error);
            }
            $loginStmt->close();
        } else {
            echo "<script>alert('Invalid password. Please try again.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('No account found with this email. Please register first.'); window.location.href='register.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    // If accessed directly
    header("Location: login.html");
    exit;
}
?>
