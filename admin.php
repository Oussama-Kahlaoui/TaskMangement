<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn-delete {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px; /* Added margin-right */
        }
        .btn-update {
            background-color: blue;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .container {
            text-align: center;
            margin-top: 20px; /* Adjusted margin-top */
        }
        #addAdminForm {
    max-width: 400px;
    margin: 0 auto;
    background: #f2f2f2;
    padding: 20px;
    border-radius: 5px;
    margin-top: 20px;
}

#addAdminForm h2 {
    margin-bottom: 20px;
}

#addAdminForm label {
    display: block;
    margin-bottom: 10px;
}

#addAdminForm input[type="text"],
#addAdminForm input[type="password"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    box-sizing: border-box;
    border-radius: 5px;
}

#addAdminForm input[type="submit"] {
    background-color: #419FE8;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Panel</h1>
        <ul>
            <li><a href="display_tasks.php">Task Management</a></li>
            <li><a href="login.php">Logout</a></li>
        </ul>
    </div>
    <div class="container">
        <h2>Admins</h2>
        <div id="addAdminForm">
            <h2>Add Admin</h2>
            <form id="adminForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br>
                <input type="submit" name="addAdmin" value="Add Admin">
            </form>
        </div>
        

        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Pass</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "f_projectphp";

            $conn = new mysqli($servername, $username, $password, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addAdmin'])) {
                $username = sanitizeInput($_POST['username']);
                $password = sanitizeInput($_POST['password']);

                $sql = "INSERT INTO admin (user, pass) VALUES ('$username', '$password')";
                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('New admin added successfully');</script>";
                    echo "<script>window.location.href = 'admin.php';</script>";
                } else {
                    echo "Error adding admin: " . $conn->error;
                }
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
                $username = sanitizeInput($_POST['user']);
                $password = sanitizeInput($_POST['pass']);

                $sql = "DELETE FROM admin WHERE user='$username' AND pass='$password'";
                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('Admin deleted successfully');</script>";
                    echo "<script>window.location.href = 'admin.php';</script>";
                } else {
                    echo "Error deleting admin: " . $conn->error;
                }
            }

            // Update admin
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
                $username = sanitizeInput($_POST['user']);
                $password = sanitizeInput($_POST['pass']);
                $updatedUsername = sanitizeInput($_POST['updated_username']);
                $updatedPassword = sanitizeInput($_POST['updated_password']);
            
                $sql = "UPDATE admin SET user='$updatedUsername', pass='$updatedPassword' WHERE user='$username' AND pass='$password'";
                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('Admin updated successfully');</script>";
                    header("Location: admin.php");
                    exit();
                } else {
                    echo "Error updating admin: " . $conn->error;
                }
            }
            
            $sql = "SELECT * FROM admin";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["user"] . "</td>";
                    echo "<td>" . $row["pass"] . "</td>";
                    echo "<td>";
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='user' value='" . $row["user"] . "'>";
                    echo "<input type='hidden' name='pass' value='" . $row["pass"] . "'>";
                    echo "<input type='text' name='updated_username' placeholder='Enter updated username'>";
                    echo "<input type='text' name='updated_password' placeholder='Enter updated password'>";
                    echo "<input type='submit' name='delete' value='Delete' class='btn-delete'>";
                    echo "<input type='submit' name='update' value='Update' class='btn-update'>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No admins found</td></tr>";
            }

            function sanitizeInput($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            ?>
            </tbody>
        </table>
    </div>
</body>
</html>
