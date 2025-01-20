<?php
require_once 'db.php';


if (isset($_POST['add_task'])) {
    $task = $conn->real_escape_string($_POST['task']);
    $sql = "INSERT INTO todos (task) VALUES ('$task')";
    $conn->query($sql);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_POST['toggle_task'])) {
    $id = (int) $_POST['id'];
    $sql = "UPDATE todos SET completed = NOT completed WHERE id = $id";
    $conn->query($sql);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}


if (isset($_POST['delete_task'])) {
    $id = (int) $_POST['delete_task'];
    $sql = "DELETE FROM todos WHERE id = $id";
    $conn->query($sql);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}


$sql = 'SELECT * FROM todos ORDER BY created_at DESC';
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html>

<head>
    <title>Todo List</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <h1>✨ Todo List ✨</h1>
    <form method="POST">
        <input type="text" name="task" placeholder="What needs to be done?" required>
        <button type="submit" name="add_task">Add Task</button>
    </form>

    <div class="todo-list">
        <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
        <div class="todo-item">
            <form method="POST" style="margin: 0; display: inline;">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="checkbox" onChange="this.form.submit()" name="toggle_task" <?php echo $row['completed'] ? 'checked' : ''; ?>>
            </form>
            <span class="<?php echo $row['completed'] ? 'completed' : ''; ?>">
                <?php echo $row['task']; ?>
            </span>
            <form method="POST" style="margin: 0; display: inline;">
                <button type="submit" name="delete_task" value="<?php echo $row['id']; ?>" class="delete-btn">×</button>
            </form>
        </div>
        <?php endwhile; ?>
        <?php else: ?>
        <p style="text-align: center; color: #7f8c8d;">No tasks yet! Add one above to get started.</p>
        <?php endif; ?>
    </div>
</body>
</html>
