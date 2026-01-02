<?php
include '../includes/db.php';

$name = $_POST['name'];
$email = $_POST['email'];
$pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
$phone = $_POST['phone'];
$addr = $_POST['address'];

$query = "INSERT INTO users (name,email,password,phone,address)
          VALUES ('$name','$email','$pass','$phone','$addr')";

mysqli_query($conn,$query);

header("Location: ../signin.php?registered=success");
?>