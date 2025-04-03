<?php
session_start();
include 'db.php';  // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL query to check if user exists with that email
    $stmt = $conn->prepare("SELECT * FROM admin_user WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Check if user exists
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Start session and store user info
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];

            // Redirect to dashboard or homepage
            header('Location: dashboard.php');
            exit;
        } else {
            $error_message = "Invalid credentials. Please try again.";
        }
    } else {
        $error_message = "User not found. Please check your email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Admin Login</h3></div>
                                    <div class="card-body">
                                        <?php if (isset($error_message)): ?>
                                            <div class="alert alert-danger"><?php echo $error_message; ?></div>
                                        <?php endif; ?>
                                        <form action="login_admin.php" method="POST">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" name="email" placeholder="name@example.com" required />
                                                <label for="inputEmail">Email address</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" type="password" name="password" placeholder="Enter your password" required />
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="register_admin.php">Don't have an account? Register</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
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
