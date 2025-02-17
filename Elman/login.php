<?php
session_start();
include 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Prepare SQL to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify hashed password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirect to index.php after successful login
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid username or password!";
        }
    } else {
        $error = "User not found!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* Background Image */
        body {
            background: url('images/hotel.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
        }

        /* Main Container */
        .container {
            max-width: 500px;
            background: rgba(255, 255, 255, 0.85);
            padding: 20px;
            border-radius: 10px;
            margin-top: 100px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Form Styling */
        .form-control {
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .btn-primary {
            border-radius: 8px;
            padding: 10px 15px;
            font-weight: bold;
            width: 100%;
        }

        .btn-primary:hover {
            background: #0056b3;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

        /* Social Login Buttons */
        .btn-social {
            width: 100%;
            font-size: 16px;
            font-weight: bold;
            padding: 10px;
            margin-top: 10px;
            border-radius: 8px;
        }

        .btn-facebook {
            background-color: #3b5998;
            color: white;
        }

        .btn-facebook:hover {
            background-color: #2d4373;
        }

        .btn-google {
            background-color: #db4437;
            color: white;
        }

        .btn-google:hover {
            background-color: #c1351d;
        }

        /* Responsive Layout */
        @media (max-width: 768px) {
            .container {
                margin-top: 50px;
                padding: 15px;
            }
        }
    </style>
</head>

<body>

<div class="container">
    <h2 class="text-center mb-4">🔐 Login</h2>

    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

    <!-- Login Form -->
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>

    <!-- Social Login Buttons -->
    <div class="text-center mt-3">
        <button class="btn btn-social btn-facebook">
            <i class="fab fa-facebook"></i> Login with Facebook
        </button>
        <button class="btn btn-social btn-google">
            <i class="fab fa-google"></i> Login with Google
        </button>
    </div>

    <p class="text-center mt-3">Don't have an account? <a href="register.php">Register here</a></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>