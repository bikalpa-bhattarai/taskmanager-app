<?php
include 'database.php';

if (isset($_POST['taskId']) && isset($_POST['newTask'])) {
    $taskId = $_POST['taskId'];
    $newTask = $_POST['newTask'];

    $taskId = mysqli_real_escape_string($conn, $taskId);
    $newTask = mysqli_real_escape_string($conn, $newTask);

    $query = "UPDATE tasklist SET task = '$newTask' WHERE id = '$taskId'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Task updated successfully";
    } else {
        echo "Error updating task: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request";
}
?>
