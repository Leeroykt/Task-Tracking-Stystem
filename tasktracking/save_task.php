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
        echo "Error: Missing form data.";
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