<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'CUSTOMER') {
    header("Location: ../login.php");
    exit();
}

require '../db.php';
$user_id = $_SESSION['user_id'];

// Fetch customer name
$query = $conn->prepare("SELECT firstname, lastname FROM customers WHERE user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$customer = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard | Handmade Collective</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f4f4f4;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background: #7d5a50;
            height: 100vh;
            color: white;
            padding-top: 30px;
            position: fixed;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 22px;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 15px 20px;
            text-decoration: none;
            font-size: 16px;
            transition: background 0.2s;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .sidebar a:hover {
            background: #a47148;
        }

        .main-content {
            margin-left: 250px;
            padding: 40px;
            width: 100%;
        }

        .welcome {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

    </style>
</head>
<body>

<div class="sidebar">
    <h2>Customer Panel</h2>
    <a href="#"><i class="fas fa-home"></i> Dashboard</a>
    <a href="#"><i class="fas fa-store"></i> Browse Products</a>
    <a href="#"><i class="fas fa-box"></i> My Orders</a>
    <a href="#"><i class="fas fa-heart"></i> Wishlist</a>
    <a href="#"><i class="fas fa-truck"></i> Track Order</a>
    <a href="#"><i class="fas fa-user"></i> My Profile</a>
    <a href="#"><i class="fas fa-bullhorn"></i> Announcements</a>
    <a href="#"><i class="fas fa-headset"></i> Contact Support</a>
    <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="main-content">
    <div class="welcome">
        <h2>Welcome, <?php echo $customer['firstname'] . ' ' . $customer['lastname']; ?>!</h2>
        <p>Explore your handmade treasures and manage your account right here.</p>
    </div>
</div>

</body>
</html>
