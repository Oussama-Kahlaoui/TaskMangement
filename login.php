<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link href="login.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <form class="form-signin" id="loginForm" action="login.php" method="post">
            <img src="logo.png" alt="Logo">
            <h2 class="form-signin-heading">Admin Dashboard</h2>
            <input type="text" class="form-control" name="username" placeholder="Email Address" required autofocus>
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <label class="checkbox">
                <input type="checkbox" value="remember-me" id="rememberMe" name="rememberMe"> Remember me
            </label>
            <button class="btn btn-lg btn-primary btn-block" type="submit" id="loginBtn">Login</button>
            
        </form>

    </div>
</body>
</html>

<?php

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "f_projectphp"; 
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE user = '$username' AND pass = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        header("Location: index.html");
        exit();
    } else {
        echo "Invalid username or password";
    }
} else {
    echo "Please provide both username and password";
}

$conn->close();
?>
