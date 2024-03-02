<?php
include 'database.php';

function displayTasks() {
    global $conn;
    $output = '';
    $query = "SELECT * FROM tasklist";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Database query failed."); 
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= '<div class="task-list">';
        $output .= '<div class="task" id="task-' . $row['id'] . '">'; // Add unique ID
        $output .= '<input type="checkbox" class="task-checkbox" id="checkbox-' . $row['id'] . '" data-taskid="' . $row['id'] . '">';
        $output .= '<label for="checkbox-' . $row['id'] . '" class="task-label">' . $row['task'] . '</label>'; // Add label for checkbox
        $output .= '<input type="text" class="task-input" id="input-' . $row['id'] . '" data-taskid="' . $row['id'] . '" value="' . $row['task'] . '" style="display: none;">'; // Add input field for editing (initially hidden)
        $output .= '</div>';
        $output .= '<div class="tick" onclick="editTask(' . $row['id'] . ')">'; // Call editTask function when clicked
        $output .= '<i class="bx bx-pencil"></i>';
        $output .= '</div>';
        $output .= '<div class="delete" onclick="deleteTask(' . $row['id'] . ')" data-taskid="' . $row['id'] . '">';
        $output .= '<i class="bx bx-x"></i>';
        $output .= '</div>';
        $output .= '</div>';
    }
    return $output;
}

if (isset($_POST['addTask'])) {
    $task = $_POST['task'];
    $query = "INSERT INTO tasklist (task) VALUES ('$task')";
    mysqli_query($conn, $query);
    header('Location: index.php');
    exit();
}
?>
