<?php
$configs = include('config.php');

// session already started in home.php
session_start();
$dbservername = $configs['host'];
$dbusername = $configs['username'];
$dbpassword = $configs['password'];
$dbName = $configs['dbname'];

$array_tickets =[];

$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbName);

if ($conn->connect_error)
  die("Connection failed: " . $conn->connect_error);


$sql = "SELECT * from ticket where status='inactive' ;";
$stmt = $conn->prepare($sql);
$stmt->execute();

$result = $stmt->get_result();
$card_number = '';
$seat = '';
$social_status='';
$passenger_name ='';
$passenger_id='';
$destination_station ='';
$departing_station ='';
$flight_id='';
$ticket_id='';
$airline_name ='';
while ($row = $result->fetch_assoc()){
  $array_temp = [];
  $passenger_id=$row['passenger_id'];
  $card_number=$row['card_number'];
  $seat = $row['seat'];
  $flight_id=$row['flight_id'];
  $ticket_id=$row['ticket_id'];

  $sql2 = "SELECT * from passenger where passenger_id =?;";
  $stmt2 = $conn->prepare($sql2);
  $stmt2->bind_param('s',$passenger_id);
  $stmt2->execute();
  $result2 = $stmt2->get_result();
  while ($row1 = $result2->fetch_assoc()){
    $passenger_name=$row1['first_name'].' '.$row1['last_name'];
    $social_status = $row1['social_status'];
  }
  $sql3 ="SELECT * from flight where flight_id=?;";
  $stmt3 = $conn->prepare($sql3);
  $stmt3->bind_param('s',$flight_id);
  $stmt3->execute();
  $result = $stmt3->get_result();
  while ($row1 = $result->fetch_assoc()){
    $airline_name=$row1['airline_name'];
    $destination_station=$row1['departing_station'];
    $departing_station=$row1['destination_station'];
  }
  array_push($array_tickets,[$ticket_id,$airline_name,$departing_station,$destination_station,$seat,$passenger_name,$social_status]);
}
?>