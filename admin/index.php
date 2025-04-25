<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'ADMIN') {
    header("Location: ../login.php");
    exit();
}

require '../db.php';

$admin_id = $_SESSION['user_id'];
$query = $conn->prepare("SELECT * FROM user WHERE user_id = ?");
$query->bind_param("i", $admin_id);
$query->execute();
$result = $query->get_result();
$admin = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | Handmade Collective</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
        }

        .sidebar {
            width: 230px;
            height: 100vh;
            background-color: #2f2f2f;
            color: white;
            position: fixed;
            padding-top: 20px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            margin: 5px 10px;
            background-color: #444;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        .logout-btn {
            background-color: red !important;
            color: white;
            font-weight: bold;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Handmade Collective</h2>
        <a href="index.php?page=dashboard">Dashboard</a>
        <a href="#">Settings</a>
        <a href="index.php?page=manage_users">Manage Users</a>
        <a href="#">Orders</a>
        <a href="#">Calendar</a>
        <a href="#">Products</a>
        <a href="#">Announcements</a>
        <a href="#">Report & Analytics</a>
        <a href="../logout.php" class="logout-btn">LOG OUT</a>
    </div>

    <div class="main-content">
        <?php
        $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
        $file = $page . '.php';

        if (file_exists($file)) {
            include $file;
        } else {
            echo "<h2>Page not found</h2>";
        }
        ?>
    </div>
</body>
</html>
