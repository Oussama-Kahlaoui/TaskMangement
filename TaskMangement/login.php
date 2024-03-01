<?php
// Establish connection to the database
$servername = "localhost"; // Assuming your database is on localhost
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "f_projectphp"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve username and password from the form
$username = $_POST['username'];
$password = $_POST['password'];

// Prepare SQL statement to check if username and password exist in the database
$sql = "SELECT * FROM admin WHERE user = '$username' AND pass = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // User exists in the database, redirect to index.html
    header("Location: index.html");
    exit();
} else {
    // User does not exist or username/password is incorrect
    echo '<p class="error-message">Login error: Username or password is incorrect.</p>';
    
}

$conn->close();
?>
