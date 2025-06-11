<?php
$conn = new mysqli('localhost', 'root', '', 'quiz_proj');

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

$sql = "SELECT * FROM login";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Details</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px 12px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
<?php
if ($result && $result->num_rows > 0) {
    echo "<h1>Login Details</h1>";
    echo "<table>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Login Time</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['id']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . htmlspecialchars($row['login_time']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p style='text-align:center;'>No login details found.</p>";
}

$conn->close();
?>
</body>
</html>
