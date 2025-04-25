<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('db.php');

    $email = $_POST['email'];
    $password = hash('sha256', $_POST['password']);
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $middlename = $_POST['middlename'];

    // INSERT into user table
    $stmt1 = $conn->prepare("INSERT INTO user (email, password, role, phone, address) VALUES (?, ?, 'CUSTOMER', ?, ?)");
    if (!$stmt1) {
        die("User insert prepare failed: " . $conn->error);
    }
    $stmt1->bind_param("ssss", $email, $password, $phone, $address);

    if ($stmt1->execute()) {
        $user_id = $conn->insert_id;

        // INSERT into customers table
        $stmt2 = $conn->prepare("INSERT INTO customers (user_id, firstname, lastname, middlename) VALUES (?, ?, ?, ?)");
        if (!$stmt2) {
            die("Customer insert prepare failed: " . $conn->error);
        }
        $stmt2->bind_param("isss", $user_id, $firstname, $lastname, $middlename);

        if ($stmt2->execute()) {
            echo "<script>alert('Registration successful! You can now login.'); window.location.href='login.php';</script>";
        } else {
            echo "Error inserting customer info: " . $stmt2->error;
        }

        $stmt2->close();
    } else {
        echo "Error inserting user info: " . $stmt1->error;
    }

    $stmt1->close();
    $conn->close();
}
?>
