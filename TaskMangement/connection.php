<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "f_projectphp";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the data from the form
$task = $_POST['task'];
$priority = $_POST['priority'];

// Insert data into database
$sql = "INSERT INTO task (task, user, description) VALUES ('$task', '$priority', '')";

if ($conn->query($sql) === TRUE) {
    
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
