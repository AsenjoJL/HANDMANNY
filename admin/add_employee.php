<?php
session_start();
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $middlename = $_POST['middlename'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Insert into user table
    $stmtUser = $conn->prepare("INSERT INTO user (email, password, role, phone, address) VALUES (?, ?, 'EMPLOYEE', ?, ?)");
    $stmtUser->bind_param("ssss", $email, $password, $phone, $address);
    $stmtUser->execute();
    $user_id = $stmtUser->insert_id;

    // Insert into employee table
    $stmtEmp = $conn->prepare("INSERT INTO EMPLOYEE (user_id, firstname, lastname, middlename) VALUES (?, ?, ?, ?)");
    $stmtEmp->bind_param("isss", $user_id, $firstname, $lastname, $middlename);
    $stmtEmp->execute();

    // Redirect back to manage_users view
    header("Location: index.php?page=manage_users");
    exit();
} else {
    echo "Invalid request.";
}
?>
