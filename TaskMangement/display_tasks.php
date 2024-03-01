<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "f_projectphp";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM task";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<div class='task'>";
        echo "<h3>" . $row["task"] . "</h3>";
        echo "<p><strong>Priority:</strong> " . $row["user"] . "</p>";
        echo "<p><strong>Description:</strong> " . $row["description"] . "</p>";
        // You can add more fields as needed
        echo "</div>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>
