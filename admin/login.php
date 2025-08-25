<?php
session_start();

// Hardcoded credentials
$valid_username = "admin237";
$valid_password = "0000";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = trim($_POST["username"]);
    $input_password = trim($_POST["password"]);

    if ($input_username === $valid_username && $input_password === $valid_password) {
        $_SESSION["loggedin"] = true;
        $_SESSION["admin_username"] = $input_username;

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - Aunty Co's Kitchen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #d4a574, #b8956a);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }

        .login-box h2 {
            margin-bottom: 20px;
            color: #b8956a;
        }

        .form-control:focus {
            border-color: #d4a574;
            box-shadow: none;
        }

        .btn-primary {
            background-color: #b8956a;
            border-color: #b8956a;
        }

        .btn-primary:hover {
            background-color: #a48157;
            border-color: #a48157;
        }

        .error-message {
            color: red;
            font-size: 0.95rem;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2 class="text-center">Admin Login</h2>

    <?php if (isset($error)) : ?>
        <p class="error-message text-center"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required placeholder="Enter username">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required placeholder="Enter password">
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
</div>

</body>
</html>
