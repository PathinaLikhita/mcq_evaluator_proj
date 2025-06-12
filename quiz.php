<?php
session_start();
include('db_connection.php'); // Make sure this file exists and connects to MySQL

// Check login session
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check previous attempts
$checkAttempts = mysqli_query($conn, "SELECT COUNT(*) as attempts FROM quiz_attempts WHERE user_id = '$user_id'");
$row = mysqli_fetch_assoc($checkAttempts);

if ($row['attempts'] >= 3) {
    echo "<script>alert('You have reached the maximum number of attempts.'); window.location.href='dashboard.php';</script>";
    exit();
}

// Fetch randomized questions (10 questions)
$questions = mysqli_query($conn, "SELECT * FROM questions ORDER BY RAND() LIMIT 10");
$_SESSION['questions'] = [];

while ($q = mysqli_fetch_assoc($questions)) {
    $_SESSION['questions'][] = $q;
}

// Record new attempt
mysqli_query($conn, "INSERT INTO quiz_attempts (user_id, start_time) VALUES ('$user_id', NOW())");
$attempt_id = mysqli_insert_id($conn);
$_SESSION['attempt_id'] = $attempt_id;

header("Location: quiz.html");
exit();
?>
