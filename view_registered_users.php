<?php
$conn = new mysqli('localhost', 'root', '', 'quiz_proj');

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

$sql = "SELECT * FROM register";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registered Users</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 30px auto;
        }
        th, td {
            border: 1px solid #444;
            padding: 10px 15px;
            text-align: center;
        }
        th {
            background-color: #3c8dbc;
            color: white;
        }
        h1 {
            text-align: center;
            margin-top: 40px;
            font-family: Arial, sans-serif;
            color: #333;
        }
        p {
            text-align: center;
            font-family: Arial, sans-serif;
            color: #777;
            margin-top: 40px;
        }
    </style>
</head>
<body>
<?php
if ($result && $result->num_rows > 0) {
    echo "<h1>Registered Users</h1>";
    echo "<table>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Mobile Number</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['id']) . "</td>
                <td>" . htmlspecialchars($row['fname']) . "</td>
                <td>" . htmlspecialchars($row['lname']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . htmlspecialchars($row['mobileNumber']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No registered users found.</p>";
}

$conn->close();
?>
</body>
</html>
