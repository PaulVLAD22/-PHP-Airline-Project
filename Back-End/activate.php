<?php
$configs = include('config.php');
session_start();

$email=$_SESSION['email'];
$token =$_POST['tokenInput'];

$dbservername = $configs['host'];
$dbusername = $configs['username'];
$dbpassword = $configs['password'];
$dbName = $configs['dbname'];

function generateRandomString($length = 10) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}
$random=generateRandomString();
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbName);

if ($conn->connect_error)
  die("Connection failed: " . $conn->connect_error);

$sql="update passenger set status='active' where email = ? and token = ?;";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss",$email,$token);
$stmt->execute();
if (!($stmt->error)){
  $_SESSION['loggedIn'] = true;
  $sql2 = "update passenger set token = ? where email = ?";
  $stmt1 = $conn->prepare($sql2);
  $stmt1->bind_param("ss",$random,$email);
  $stmt1->execute();
  header('location:/home.php');
  }
  else{
    header('location:/activatePage.php');
  }
  


$conn->close();

?>