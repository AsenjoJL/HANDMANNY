<?php
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'ADMIN') {
    header("Location: ../login.php");
    exit();
}

include '../db.php';

// Handle employee form submission
if (isset($_POST['add_employee'])) {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = hash('sha256', $_POST['password']);
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $role = 'EMPLOYEE';

    $stmt1 = $conn->prepare("INSERT INTO user (email, password, phone, address, role) VALUES (?, ?, ?, ?, ?)");
    $stmt1->bind_param("sssss", $email, $password, $phone, $address, $role);

    if ($stmt1->execute()) {
        $user_id = $stmt1->insert_id;

        $stmt2 = $conn->prepare("INSERT INTO EMPLOYEE (user_id, firstname, lastname, middlename) VALUES (?, ?, ?, ?)");
        $stmt2->bind_param("isss", $user_id, $firstname, $lastname, $middlename);
        $stmt2->execute();

        echo "<script>alert('Employee added successfully!'); window.location.href='index.php?page=manage_users';</script>";
    } else {
        echo "<script>alert('Error: Email or phone might already exist.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users | Admin</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        h2 {
            color: #7d5a50;
            margin-top: 40px;
        }

        .add-btn {
            background: #7d5a50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            float: right;
            cursor: pointer;
        }

        .add-btn:hover {
            background: #a47148;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 10;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
        }

        .modal-content {
            background: white;
            width: 500px;
            margin: 80px auto;
            padding: 30px;
            border-radius: 10px;
            position: relative;
        }

        .modal-content input[type="text"],
        .modal-content input[type="email"],
        .modal-content input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #aaa;
            border-radius: 5px;
        }

        .modal-content input[type="submit"] {
            background: #7d5a50;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-top: 10px;
            border-radius: 5px;
        }

        .close-btn {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Employee List</h2>
        <button class="add-btn" onclick="document.getElementById('employeeModal').style.display='block'">Add Employee</button>

        <table>
            <tr>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Middlename</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
            </tr>
            <?php
            $queryEmp = $conn->query("SELECT e.firstname, e.lastname, e.middlename, u.email, u.phone, u.address
                                      FROM employee e
                                      JOIN user u ON e.user_id = u.user_id");
            while ($row = $queryEmp->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['firstname']}</td>
                        <td>{$row['lastname']}</td>
                        <td>{$row['middlename']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['address']}</td>
                      </tr>";
            }
            ?>
        </table>

        <h2>Customer List</h2>
        <table>
            <tr>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Middlename</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
            </tr>
            <?php
            $queryCust = $conn->query("SELECT c.firstname, c.lastname, c.middlename, u.email, u.phone, u.address
                                       FROM customers c
                                       JOIN user u ON c.user_id = u.user_id");
            while ($row = $queryCust->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['firstname']}</td>
                        <td>{$row['lastname']}</td>
                        <td>{$row['middlename']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['address']}</td>
                      </tr>";
            }
            ?>
        </table>
    </div>

    <!-- Add Employee Modal -->
    <div class="modal" id="employeeModal">
        <div class="modal-content">
            <span class="close-btn" onclick="document.getElementById('employeeModal').style.display='none'">&times;</span>
            <h3>Add Employee</h3>
            <form method="POST" action="">
                <input type="text" name="firstname" placeholder="First Name" required>
                <input type="text" name="middlename" placeholder="Middle Name">
                <input type="text" name="lastname" placeholder="Last Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="text" name="phone" placeholder="Phone" required>
                <input type="text" name="address" placeholder="Address">
                <input type="submit" name="add_employee" value="Add Employee">
            </form>
        </div>
    </div>

    <script>
        // Close modal if user clicks outside
        window.onclick = function(event) {
            const modal = document.getElementById('employeeModal');
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
