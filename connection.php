<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "f_projectphp";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$task = $_POST['task'];
$priority = $_POST['priority'];

$sql = "INSERT INTO task (task, user, description) VALUES ('$task', '$priority', '')";

if ($conn->query($sql) === TRUE) {
    
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
