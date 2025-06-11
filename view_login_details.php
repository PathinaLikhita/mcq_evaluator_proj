<?php
$conn = new mysqli('localhost', 'root', '', 'mcq_evaluator');

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

$sql = "SELECT * FROM login";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Login Details</h1>";
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Password</th>
                <th>Login Time</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['email']}</td>
                <td>{$row['password']}</td>
                <td>{$row['login_time']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No login details found.";
}

$conn->close();
?>
