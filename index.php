<?php include 'functions.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rethink+Sans&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- or -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="icon.png">
    <title>Task Manager</title>
</head>

<body>
    <div class="container">
        <div class="main">
            <h2>Task Manager</h2>
            <form action="functions.php" method="POST">
                <div class="input-thing">
                    <input type="text" name="task" placeholder="Enter a Task" autocomplete="off" required spellcheck="true" >
                    <button type="submit" name="addTask">Add</button>
                </div>
            </form>
            <div class="task-lists">
            <?php echo displayTasks(); ?>
              </div>
        </div>
    </div>



    <script>
    document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.task-checkbox');
    checkboxes.forEach(function(checkbox) {
        const taskId = checkbox.getAttribute('data-taskid');
        const taskElement = document.getElementById('task-' + taskId);
        
        // Check if task is completed in local storage
        const isCompleted = localStorage.getItem('task-' + taskId);
        if (isCompleted === 'true') {
            checkbox.checked = true;
            taskElement.style.textDecoration = 'line-through';
        }

        checkbox.addEventListener('change', function() {
            const taskId = this.getAttribute('data-taskid');
            const taskElement = document.getElementById('task-' + taskId);
            if (this.checked) {
                taskElement.style.textDecoration = 'line-through';
                // Store completed state in local storage
                localStorage.setItem('task-' + taskId, true);
            } else {
                taskElement.style.textDecoration = 'none';
                // Remove completed state from local storage
                localStorage.removeItem('task-' + taskId);
            }
        });
    });
});

</script>
<script>
    function deleteTask(taskId) {
        if (confirm("Are you sure you want to delete this task?")) {
            // Send AJAX request to delete the task from the database
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete_task.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                   
                    const taskListElement = document.getElementById('task-' + taskId).closest('.task-list');
                    taskListElement.parentNode.removeChild(taskListElement);
                }
            };
            xhr.send('taskId=' + taskId);
        }
    }
</script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/dist/boxicons.js"
        integrity="sha512-Dm5UxqUSgNd93XG7eseoOrScyM1BVs65GrwmavP0D0DujOA8mjiBfyj71wmI2VQZKnnZQsSWWsxDKNiQIqk8sQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script>
    function editTask(taskId) {
        const label = document.getElementById('task-' + taskId).querySelector('.task-label');
        const input = document.getElementById('task-' + taskId).querySelector('.task-input');

        label.style.display = 'none';
        input.style.display = 'block';
        input.focus(); // Focus on the input field for editing
        input.addEventListener('blur', function() {
            // When input field loses focus (user clicks outside), update task in database and hide input field
            updateTask(taskId, input.value);
            label.textContent = input.value; // Update label text
            label.style.display = '';
            input.style.display = 'none';
        });
        input.addEventListener('keyup', function(event) {
            // When user presses Enter, update task in database and hide input field
            if (event.key === 'Enter') {
                updateTask(taskId, input.value);
                label.textContent = input.value; // Update label text
                label.style.display = 'block';
                input.style.display = 'none';
            }
        });
    }

    function updateTask(taskId, newTask) {
        // Send an AJAX request to update the task in the database
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_task.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
            }
        };
        xhr.send('taskId=' + taskId + '&newTask=' + encodeURIComponent(newTask));
    }
</script>

</body>

</html>