<?php
include 'database.php';

if (isset($_POST['taskId'])) {
    $taskId = $_POST['taskId'];

    $taskId = mysqli_real_escape_string($conn, $taskId);

    $query = "DELETE FROM tasklist WHERE id = '$taskId'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Task deleted successfully";
    } else {
        echo "Error deleting task: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request";
}
?>
