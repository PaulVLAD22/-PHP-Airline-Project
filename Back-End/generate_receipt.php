<?php
$configs = include('config.php');

// session already started in home.php
session_start();
$dbservername = $configs['host'];
$dbusername = $configs['username'];
$dbpassword = $configs['password'];
$dbName = $configs['dbname'];

$ticket_id = $_POST['ticket_id'];
$first_name = $_SESSION['fisrt_name'];
$last_name = $_SESSION['last_name'];
$email = $_SESSION['email'];

$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbName);

if ($conn->connect_error)
  die("Connection failed: " . $conn->connect_error);

$stmt = $conn->prepare("select * from ticket where ticket_id = ? ");

$stmt->bind_param('s', $ticket_id);

$stmt->execute();
$result = $stmt->get_result();
$correctAccount = false;


while ($row = $result->fetch_assoc()) {
  $correctAccount = true;
}



?>