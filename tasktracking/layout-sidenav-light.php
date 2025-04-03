<?php
// Database connection parameters
$servername = "localhost";
$username = "root";        
$password = "";            
$dbname = "task_tracker"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch users for the dropdown
$userQuery = "SELECT id, first_name FROM users";
$userResult = $conn->query($userQuery);

// Fetch tasks for the dropdown
$taskQuery = "SELECT task_id, task_title FROM tasks";
$taskResult = $conn->query($taskQuery);

// Handle form submission for task assignment
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['task_id'];
    $user_id = $_POST['user_id'];
    $due_date = $_POST['due_date'];
    $priority = $_POST['priority'];
    $comments = $_POST['comments'];

    // Insert task assignment into database
    $assignQuery = "INSERT INTO task_assignments (task_id, user_id, due_date, priority, comments)
                    VALUES ('$task_id', '$user_id', '$due_date', '$priority', '$comments')";

    if ($conn->query($assignQuery) === TRUE) {
        $message = "Task assigned successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Assign Task</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="dashboard.php">Task Tracker</a>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                        <a class="nav-link" href="layout-static.php">Create Task</a>
                        <a class="nav-link" href="layout-sidenav-light.html">Assign Task</a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Assign Task</h1>

                    <!-- Display Success/Failure Message -->
                    <?php if (isset($message)): ?>
                        <div class="alert alert-info"><?php echo $message; ?></div>
                    <?php endif; ?>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Assign a Task</h5>

                            <form action="layout-sidenav-light.php" method="POST">
                                <div class="row">
                                    <!-- Select Task Dropdown -->
                                    <div class="col-md-6 mb-3">
                                        <label for="task_id" class="form-label">Select Task</label>
                                        <select id="task_id" name="task_id" class="form-select" required>
                                            <option value="">Select a Task</option>
                                            <?php while ($task = $taskResult->fetch_assoc()): ?>
                                                <option value="<?php echo $task['task_id']; ?>"><?php echo $task['task_title']; ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>

                                    <!-- Select User Dropdown -->
                                    <div class="col-md-6 mb-3">
                                        <label for="user_id" class="form-label">Assign to User</label>
                                        <select id="user_id" name="user_id" class="form-select" required>
                                            <option value="">Select a User</option>
                                            <?php while ($user = $userResult->fetch_assoc()): ?>
                                                <option value="<?php echo $user['id']; ?>"><?php echo $user['first_name']; ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Due Date Input -->
                                    <div class="col-md-6 mb-3">
                                        <label for="due_date" class="form-label">Due Date</label>
                                        <input type="date" id="due_date" name="due_date" class="form-control" required>
                                    </div>

                                    <!-- Priority Dropdown -->
                                    <div class="col-md-6 mb-3">
                                        <label for="priority" class="form-label">Priority</label>
                                        <select id="priority" name="priority" class="form-select" required>
                                            <option value="">Select Priority</option>
                                            <option value="low">Low</option>
                                            <option value="medium">Medium</option>
                                            <option value="high">High</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Additional Comments -->
                                <div class="mb-3">
                                    <label for="comments" class="form-label">Additional Comments</label>
                                    <textarea id="comments" name="comments" class="form-control" rows="3" placeholder="Enter any additional comments"></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Assign Task</button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
