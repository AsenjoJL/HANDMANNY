<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'EMPLOYEE') {
    header("Location: ../login.php");
    exit();
}
include '../db.php';
$user_id = $_SESSION['user_id'];

$empQuery = $conn->prepare("SELECT firstname, lastname FROM EMPLOYEE WHERE user_id = ?");
$empQuery->bind_param("i", $user_id);
$empQuery->execute();
$empData = $empQuery->get_result()->fetch_assoc();
$fullname = $empData['firstname'] . " " . $empData['lastname'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { font-family: Arial; margin: 0; background: #f7f7f7; }
        .sidebar {
            width: 220px; height: 100vh; background: #2c3e50; color: white; position: fixed;
            padding-top: 20px;
        }
        .sidebar a {
            display: flex; align-items: center;
            color: white; padding: 12px 20px; text-decoration: none;
        }
        .sidebar a:hover { background: #34495e; }
        .sidebar i { margin-right: 10px; }

        .main { margin-left: 240px; padding: 20px; }
        h2 { margin-top: 0; }
        ul { list-style-type: none; padding-left: 0; }
        ul li { margin: 10px 0; }
        ul li i { color: #2c3e50; margin-right: 8px; }

        table {
            width: 100%; border-collapse: collapse; margin-top: 20px; background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px; border: 1px solid #ddd; text-align: left;
        }
        th {
            background-color: #2c3e50; color: white;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h3 style="text-align:center; margin-bottom: 30px;"><i class="fa-solid fa-hand-holding-heart"></i><br>Handmade</h3>
    <a href="index.php"><i class="fa-solid fa-chart-line"></i>Dashboard</a>
    <a href="profile.php"><i class="fa-solid fa-user"></i>Profile</a>
    <a href="../logout.php" style="color: red;"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
</div>

<div class="main">
    <h2><i class="fa-solid fa-house-user"></i> Welcome, <?php echo htmlspecialchars($fullname); ?></h2>

    <h3><i class="fa-solid fa-list-check"></i> Your Tasks</h3>
    <ul>
        <li><i class="fa-solid fa-box"></i> Process pending orders</li>
        <li><i class="fa-solid fa-warehouse"></i> Update stock and inventory</li>
        <li><i class="fa-solid fa-truck-fast"></i> Coordinate with delivery team</li>
    </ul>

    <h3><i class="fa-solid fa-clipboard-list"></i> Recent Orders</h3>
    <table>
        <thead>
            <tr><th>Order ID</th><th>Customer</th><th>Status</th><th>Amount</th></tr>
        </thead>
        <tbody>
            <tr><td>#101</td><td>Jane Doe</td><td><i class="fa-solid fa-truck"></i> Shipped</td><td>$100</td></tr>
            <tr><td>#102</td><td>Mark Lee</td><td><i class="fa-solid fa-spinner"></i> Processing</td><td>$75</td></tr>
            <tr><td>#103</td><td>Anna Kim</td><td><i class="fa-solid fa-check"></i> Delivered</td><td>$150</td></tr>
        </tbody>
    </table>
</div>

</body>
</html>
