<?php
$configs = include('config.php');
session_start();
$username=$_SESSION['username'];
if (isset($_POST['submit'])){

  $dbservername = $configs['host'];
  $dbusername = $configs['username'];
  $dbpassword = $configs['password'];
  $dbName = $configs['dbname'];
  $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbName);
  if ($conn->connect_error)
      die("Connection failed: " . $conn->connect_error);
  $passenger_id='';
  $sql1="select passenger_id from passenger where username=? ;";
  $stmt1=$conn->prepare($sql1);
  $stmt1->bind_param("s",$username);
  if ($stmt1->execute()===TRUE){
    echo "OK";
  }
  $result = $stmt1->get_result();
  while ($row=$result->fetch_assoc()){
    $passenger_id=$row['passenger_id'];
  }


  $sql = "delete from ticket where passenger_id=? and ticket_id in(select c.ticket_id from (select ticket_id from ticket,flight where ticket.flight_id=flight.flight_id and flight.flight_departure_date<sysdate() ) as c);";
  $stmt = $conn->prepare($sql);

  $stmt->bind_param("s", $passenger_id);

  if ($stmt->execute() === TRUE)
    echo "OK";


  header('location:../home.php');
}



?>