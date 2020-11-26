<?php
$configs = include('config.php');
session_start();


$email=$_SESSION['email'];
$password = $_POST['passwordInput'];
$passwordConfirm = $_POST['passwordConfirmInput'];
$dbservername = $configs['host'];
$dbusername = $configs['username'];
$dbpassword = $configs['password'];
$dbName = $configs['dbname'];

$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbName);

if ($conn->connect_error)
  die("Connection failed: " . $conn->connect_error);

$sql = "update passenger set password = ? where email = ?;";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss",password_hash($password,PASSWORD_BCRYPT), $email);
$stmt->execute();

if ($stmt->execute()===True){
   header('location:../index.php');
}
else{
  header('location:../resetPassPage.php');
}
$conn->close();



?>