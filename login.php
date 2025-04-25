<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Handmade Collective</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f1ee;
        }

        .login-form {
            width: 350px;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #ccc;
            background: #fff;
            border-radius: 8px;
        }

        .login-form h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #7d5a50;
        }

        .login-form input[type="text"],
        .login-form input[type="password"],
        .login-form input[type="email"],
        .login-form input[type="tel"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #aaa;
            border-radius: 5px;
        }

        .login-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background: #7d5a50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-form input[type="submit"]:hover {
            background: #a47148;
        }

        .register-link {
            text-align: center;
            margin-top: 10px;
        }

        .register-link a {
            color: #7d5a50;
            text-decoration: none;
            font-size: 14px;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 99;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
        }

        .modal-content {
            background: white;
            width: 400px;
            margin: 100px auto;
            padding: 20px;
            border-radius: 10px;
            position: relative;
        }

        .close-btn {
            position: absolute;
            right: 15px;
            top: 10px;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <form class="login-form" method="POST" action="login.php">
        <h2>Login</h2>
        <input type="text" name="email" placeholder="Enter Email" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <input type="submit" name="login" value="Login">
        <div class="register-link">
            Don’t have an account? <a href="#" onclick="document.getElementById('registerModal').style.display='block'">Register here</a>
        </div>
    </form>

    <!-- Registration Modal -->
    <div id="registerModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="document.getElementById('registerModal').style.display='none'">&times;</span>
            <h2>Customer Registration</h2>
            <form method="POST" action="register.php">
                <input type="text" name="firstname" placeholder="First Name" required>
                <input type="text" name="middlename" placeholder="Middle Name">
                <input type="text" name="lastname" placeholder="Last Name" required>
                <input type="email" name="email" placeholder="Enter Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="text" name="phone" placeholder="Phone" required>
                <input type="text" name="address" placeholder="Address">
                <input type="submit" value="Register">
            </form>

        </div>
    </div>

    <!-- PHP Login Logic -->
<?php
session_start();
if (isset($_POST['login'])) {
    include('db.php');

    $email = $_POST['email'];
    $password = hash('sha256', $_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'ADMIN') {
            echo "<script>alert('Login successful as ADMIN'); window.location.href='admin/index.php';</script>";
        } 
        elseif ($user['role'] === 'EMPLOYEE') {
            echo "<script>alert('Login successful as EMPLOYEE'); window.location.href='employee/index.php';</script>";
        }
        elseif ($user['role'] === 'CUSTOMER') {
            echo "<script>alert('Login successful as CUSTOMER'); window.location.href='customer/index.php';</script>";
        } else {
            echo "<script>alert('Role not recognized.');</script>";
        }
        
    } else {
        echo "<script>alert('Invalid email or password');</script>";
    }
}
?>


    <script>
        // Close modal on outside click
        window.onclick = function(e) {
            const modal = document.getElementById('registerModal');
            if (e.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
