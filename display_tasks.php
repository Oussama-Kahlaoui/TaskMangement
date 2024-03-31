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
        .btn-complete { /* New button style */
            background-color: black;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px; /* Added margin-right */
        }
        .container {
            text-align: center;
        }
        #addTaskForm {
            max-width: 400px;
            margin: 0 auto;
            background: #f2f2f2;
            padding: 20px;
            border-radius: 5px;
            margin-left: 20px;
        }
        #addTaskForm h2 {
            margin-bottom: 20px;
        }
        #addTaskForm label {
            display: block;
            margin-bottom: 10px;
        }
        #addTaskForm input[type="text"], #addTaskForm textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border-radius: 5px;
        }
        #addTaskForm textarea {
            height: 100px;
        }
        #addTaskForm input[type="submit"] {
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
        <h1>Ensa Management Task</h1>
        <ul>
            <li><a href="display_tasks.php">Task Management</a></li>
            <li><a href="admin.php">Administration</a></li>
            <li><a href="mark_complete.php">Task complete</a></li>
            <li><a href="login.php">Logout</a></li>
        </ul>
    </div>

    <!-- Add Task Form -->
    <div id="addTaskForm">
        <h2>Add Task</h2>
        <form id="taskForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="task">Task:</label>
            <input type="text" id="task" name="task" required><br>
            <label for="priority">Priority:</label>
            <input type="text" id="priority" name="priority" required><br>
            <label for="description">Description:</label><br>
            <textarea id="description" name="description" rows="4" cols="50" required></textarea><br>
            <input type="submit" name="addTask" value="Add Task">
        </form>
    </div>

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addTask'])) {
        $task = $_POST['task'];
        $priority = $_POST['priority'];
        $description = $_POST['description'];

        $sql = "INSERT INTO task (task, priority, description) VALUES ('$task', '$priority', '$description')";

        if ($conn->query($sql) === TRUE) {
            echo "New task added successfully";
            header("Location: display_tasks.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['deleteTask'])) {
        $taskId = $_POST['taskId'];
        $sql = "DELETE FROM task WHERE id=$taskId";

        if ($conn->query($sql) === TRUE) {
            echo "Task deleted successfully";
            header("Location: display_tasks.php");
            exit();
        } else {
            echo "Error deleting task: " . $conn->error;
        }
    } elseif (isset($_POST['updateTask'])) {
        // Redirect to update.php with task details
        $taskId = $_POST['taskId'];
        $updatedTask = $_POST['updatedTask'];
        $updatedPriority = $_POST['updatedPriority'];
        $updatedDescription = $_POST['updatedDescription'];
        header("Location: update.php?taskId=$taskId&updatedTask=$updatedTask&updatedPriority=$updatedPriority&updatedDescription=$updatedDescription");
        exit();
    } elseif (isset($_POST['completeTask'])) {
        $taskId = $_POST['taskId'];
        $sql = "SELECT * FROM task WHERE id=$taskId";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $task = $row['task'];
            $priority = $row['priority'];
            $description = $row['description'];
            $insertSql = "INSERT INTO task_complete (task, priority, description) VALUES ('$task', '$priority', '$description')";
            if ($conn->query($insertSql) === TRUE) {
                echo "Task marked as complete successfully";
                // Optionally, you can delete the completed task from the task table
                $deleteSql = "DELETE FROM task WHERE id=$taskId";
                if ($conn->query($deleteSql) === TRUE) {
                    echo "Task deleted from task list";
                } else {
                    echo "Error deleting task from task list: " . $conn->error;
                }
                header("Location: display_tasks.php");
                exit();
            } else {
                echo "Error marking task as complete: " . $conn->error;
            }
        } else {
            echo "Task not found";
        }
    }
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
        echo "<form action='' method='post'>"; // Changed action to empty string
        echo "<input type='hidden' name='taskId' value='" . $row['id'] . "'>";
        echo "<input type='hidden' name='updatedTask' value='" . htmlspecialchars($row["task"]) . "'>";
        echo "<input type='hidden' name='updatedPriority' value='" . htmlspecialchars($row["priority"]) . "'>";
        echo "<input type='hidden' name='updatedDescription' value='" . htmlspecialchars($row["description"]) . "'>";
        echo "<input type='submit' name='deleteTask' value='Delete' class='btn-delete'>";
        echo "<input type='submit' name='updateTask' value='Update' class='btn-update'>";
        echo "<input type='submit' name='completeTask' value='Task Complete' class='btn-complete'>"; // New button
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>0 results</td></tr>";
}

$conn->close();
?>
