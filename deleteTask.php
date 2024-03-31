<!DOCTYPE html>
<html>
<head>
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
        }
        .container {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ensa Management Task</h1>
        <ul>
            <li><a href="display_tasks.php">Task Management</a></li>
            <li><a href="#attendance">Attendailie</a></li>
            <li><a href="admin.php">Administration</a></li>
            <li><a href="login.php">Logout</a></li>
        </ul>
    </div>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "f_projectphp";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['deleteTask'])) {
        $taskId = $_POST['taskId'];
        $sql ="DELETE FROM task WHERE id=$taskId";

        if ($conn->query($sql) === TRUE) {
            echo "Task deleted successfully";
            header("Location: display_tasks.php");
            exit();
        } else {
            echo "Error deleting task: " . $conn->error;
        }
    }

    $conn->close();
    ?>

    <table>
        <thead>
            <tr>
                <th>Task</th>
                <th>Priority</th>
                <th>Description</th>
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

        $sql = "SELECT * FROM task";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["task"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["priority"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                echo "<td>";
                echo "<form action='deleteTask.php' method='post'>";
                echo "<input type='hidden' name='taskId' value='" . $row['id'] . "'>";
                echo "<input type='submit' name='deleteTask' value='Delete' class='btn-delete'>";
                echo "</form>";
                echo "<form action='update.php' method='get'>";
                echo "<input type='hidden' name='taskId' value='" . $row['id'] . "'>";
                echo "<input type='hidden'name='updatedTask' value='" . htmlspecialchars($row["task"]) . "'>";
                echo "<input type='hidden' name='updatedPriority' value='" . htmlspecialchars($row["priority"]) . "'>";
                echo "<input type='hidden' name='updatedDescription' value='" . htmlspecialchars($row["description"]) . "'>";
                echo "<input type='submit' name='updateTask' value='Update' class='btn-update'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>0 results</td></tr>";
        }

        $conn->close();
        ?>
        </tbody>
    </table>
</body>
</html>