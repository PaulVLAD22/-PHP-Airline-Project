<?php
$configs = include('config.php');
session_start();

$email=$_SESSION['email'];
$token =$_POST['tokenInput'];

$dbservername = $configs['host'];
$dbusername = $configs['username'];
$dbpassword = $configs['password'];
$dbName = $configs['dbname'];

$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbName);

if ($conn->connect_error)
  die("Connection failed: " . $conn->connect_error);

$sql="update passenger set status='active' where email = '".$email."' and token= '".$token."';";

if ($conn->query($sql)){
  if(mysqli_affected_rows($conn) >0 ){
    $_SESSION['loggedIn'] = true;
    header('location:/home.php');
  }
  else{
    header('location:/activatePage.php');
  }
  
}


$conn->close();

?>