<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "f_projectphp";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['user'];
    $password = $_POST['pass'];

    $newPassword = "new_password"; // New password to be updated
    $sql = "UPDATE admin SET pass='$newPassword' WHERE user='$username'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Admin updated successfully');</script>";
        echo "<script>window.location.href = 'admin.php';</script>";
    } else {
        echo "Error updating admin: " . $conn->error;
    }

    $conn->close();
}
?>
