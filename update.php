<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        .container {
            text-align: center;
        }
        #updateTaskForm {
            max-width: 400px;
            margin: 0 auto;
            background: #f2f2f2;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
        #updateTaskForm h2 {
            margin-bottom: 20px;
        }
        #updateTaskForm label {
            display: block;
            margin-bottom: 10px;
        }
        #updateTaskForm input[type="text"], #updateTaskForm textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border-radius: 5px;
        }
        #updateTaskForm textarea {
            height: 100px;
        }
        #updateTaskForm input[type="submit"] {
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
            <li><a href="#attendance">Task completed</a></li>
            <li><a href="admin.php">Administration</a></li>
            <li><a href="login.php">Logout</a></li>
        </ul>
    </div>

    <div class="container">
        <h1>Update Task</h1>
    </div>

    <div id="updateTaskForm">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h2>Update Task</h2>
            <label for="task">Task:</label>
            <input type="text" id="task" name="task" value="<?php echo isset($_GET['updatedTask']) ? htmlspecialchars($_GET['updatedTask']) : ''; ?>" required><br>
            <label for="priority">Priority:</label>
            <input type="text" id="priority" name="priority" value="<?php echo isset($_GET['updatedPriority']) ? htmlspecialchars($_GET['updatedPriority']) : ''; ?>" required><br>
            <label for="description">Description:</label><br>
            <textarea id="description" name="description" rows="4" cols="50" required><?php echo isset($_GET['updatedDescription']) ? htmlspecialchars($_GET['updatedDescription']) : ''; ?></textarea><br>
            <input type="hidden" name="taskId" value="<?php echo isset($_GET['taskId']) ? htmlspecialchars($_GET['taskId']) : ''; ?>">
            <input type="submit" name="updateTask" value="Update">
        </form>
    </div>

    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateTask'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "f_projectphp";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $taskId = $_POST['taskId'];
    $updatedTask = $_POST['task'];
    $updatedPriority = $_POST['priority'];
    $updatedDescription = $_POST['description'];

    $sql = "UPDATE task SET task=?, priority=?, description=? WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $updatedTask, $updatedPriority, $updatedDescription, $taskId);

    if ($stmt->execute()) {
        echo "<div class='container'>";
        echo "<p>Task updated successfully</p>";
        echo "</div>";
    } else {
        echo "Error updating task: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

</body>
</html>
