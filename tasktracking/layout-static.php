<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

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

// Variable to store the message to be displayed
$message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $task_title = $_POST['task_title'];
    $task_description = $_POST['task_description'];
    $task_due_date = $_POST['task_due_date'];
    $task_priority = $_POST['task_priority'];

    // Debug: Check if the form values are set
    if (empty($task_title) || empty($task_description) || empty($task_due_date) || empty($task_priority)) {
        $message = "Error: Missing form data.";
    } else {
        // Prepare the SQL query to insert the task into the database
        $sql = "INSERT INTO tasks (task_title, task_description, task_due_date, task_priority)
                VALUES ('$task_title', '$task_description', '$task_due_date', '$task_priority')";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            $message = "New task created successfully!";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close the database connection
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
        <title>Task Tracking System</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="dashboard.php">Task tracking</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#!">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <!---div class="sb-sidenav-menu-heading">Core</div-->
                            <a class="nav-link" href="dashboard.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Task
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="layout-static.php">Create Task</a>
                                    <a class="nav-link" href="layout-sidenav-light.php">Assign Task</a>
                                </nav>
                            </div>
                            <!--a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Team Members
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a--->
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Add member
                                        <!--div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div-->
                                    </a>
                                    <!--div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="login.html">Login</a>
                                            <a class="nav-link" href="register.html">Register</a>
                                            <a class="nav-link" href="password.html">Forgot Password</a>
                                        </nav>
                                    </div-->
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Delete
                                        <!--div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="401.html">401 Page</a>
                                            <a class="nav-link" href="404.html">404 Page</a>
                                            <a class="nav-link" href="500.html">500 Page</a>
                                        </nav>
                                    </div-->
                                </nav>
                            </div>
                            <!--div class="sb-sidenav-menu-heading">Addons</div-->
                            <!--a class="nav-link" href="charts.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Settings
                            </a--->
                            <a class="nav-link" href="tables.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Log Out
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
            <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Create Task</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Create Task</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Create a New Task</h5>

                                <!-- Display success or error message -->
                                <?php if ($message != ""): ?>
                                    <div class="alert alert-info"><?php echo $message; ?></div>
                                <?php endif; ?>

                                <!-- Task Form -->
                                <form action="layout-static.php" method="POST">
            <!-- Task Title Input -->
            <div class="mb-3">
                <label for="taskTitle" class="form-label">Task Title</label>
                <input type="text" id="taskTitle" name="task_title" class="form-control" placeholder="Enter task title" required>
            </div>

            <!-- Task Description Input -->
            <div class="mb-3">
                <label for="taskDescription" class="form-label">Task Description</label>
                <textarea id="taskDescription" name="task_description" class="form-control" rows="3" placeholder="Enter task description"></textarea>
            </div>

            <!-- Due Date Input -->
            <div class="mb-3">
                <label for="taskDueDate" class="form-label">Due Date</label>
                <input type="date" id="taskDueDate" name="task_due_date" class="form-control" required>
            </div>

            <!-- Priority Dropdown -->
            <div class="mb-3">
                <label for="taskPriority" class="form-label">Priority</label>
                <select id="taskPriority" name="task_priority" class="form-select" required>
                    <option value="">Select Priority</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Create Task</button>
        </form>
                            </div>
                        </div>
                    </div>
                </main>
                
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; leeroy 2025</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
