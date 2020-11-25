<?php
$configs = include('config.php');
$ticket_id=$_POST['ticket_id_input'];

$ticket_id=preg_replace('/[^0-9]/', '', $ticket_id);


$dbservername = $configs['host'];
$dbusername = $configs['username'];
$dbpassword = $configs['password'];
$dbName = $configs['dbname'];
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbName);
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);

if (isset($_POST['y_input'])){// confirm ticket
  $sql = "update ticket set status='active' where ticket_id=?";
  $stmt = $conn->prepare($sql);

  $stmt->bind_param("s",$ticket_id);

  if($stmt->execute()===TRUE)
    echo "OK";
}
else{
  $sql ="DELETE FROM ticket where ticket_id = ? ;";

  $stmt = $conn->prepare($sql);

  $stmt->bind_param("s",$ticket_id);

  if($stmt->execute()===TRUE)
    echo "ok";

}
header('location:/adminHome.php');




?>