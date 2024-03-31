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
        .container {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Completed Tasks</h1>
        <ul>
            <li><a href="display_tasks.php">Task Management</a></li>
            <li><a href="admin.php">Administration</a></li>
            <li><a href="login.php">Logout</a></li>
        </ul>
    </div>

    <table>
        <thead>
            <tr>
                <th>Task</th>
                <th>Priority</th>
                <th>Description</th>
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

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['completeTask'])) {
                $taskId = $_POST['taskId'];
                $taskName = $_POST['taskName'];
                $taskPriority = $_POST['taskPriority'];
                $taskDescription = $_POST['taskDescription'];

                $sql = "INSERT INTO task_complete (task, priority, description) VALUES ('$taskName', '$taskPriority', '$taskDescription')";
                if ($conn->query($sql) === TRUE) {
                    echo "Task marked as complete and cached successfully";
                } else {
                    echo "Error marking task as complete and caching: " . $conn->error;
                }
            }

            $sql = "SELECT * FROM task_complete";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["task"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["priority"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No completed tasks yet</td></tr>";
            }

            $conn->close();
        ?>
        </tbody>
    </table>
</body>
</html>
