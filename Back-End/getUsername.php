<?php
$configs = include('config.php');
session_start();
$email = $_SESSION['email'];
$dbservername = $configs['host'];
$dbusername = $configs['username'];
$dbpassword = $configs['password'];
$dbName = $configs['dbname'];
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbName);

if ($conn->connect_error)
  die("Connection failed: " . $conn->connect_error);

$sql="select * from passenger where email = ?;";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s',$email);
$stmt->execute();
$result = $stmt->get_result();
$username='';
while ($row = $result->fetch_assoc()){
  $username=$row['username'];
}
$_SESSION['username']=$username;
$conn->close();

?>