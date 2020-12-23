<?php
$configs = include('config.php');

$dbservername = $configs['host'];
$dbusername = $configs['username'];
$dbpassword = $configs['password'];
$dbName = $configs['dbname'];

$array_tickets_inactive=[];
$array_tickets_refused=[];
$array_tickets_active=[];

$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbName);

if ($conn->connect_error)
  die("Connection failed: " . $conn->connect_error);

$sql1 ="SELECT * from passenger where username = ?";
$stmt1=$conn->prepare($sql1);
$stmt1->bind_param("s",$_SESSION['username']);
$stmt1->execute();
$result1=$stmt1->get_result();
$passenger_id='';
while ($row = $result1->fetch_assoc()){
  $passenger_id=$row['passenger_id'];
}
function get_tickets($status,&$array){
  global $conn,$passenger_id;
  $sql = "SELECT * from ticket where passenger_id=? and status='".$status."'  ;";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s',$passenger_id);
  $stmt->execute();
  $flight_id ='';
  $ticket_id ='';
  $result = $stmt->get_result();

  while ($row = $result->fetch_assoc()){

    $flight_id =$row['flight_id'];
    $ticket_id =$row['ticket_id'];

    $sql2 = "SELECT * from flight where flight_id =?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("s",$flight_id);
    $stmt2->execute();
    $result2= $stmt2->get_result();
    $ticket_price='';
    $destination_station='';
    $departing_station='';
    $departing_date='';
    while ($row3 = $result2->fetch_assoc()){
      $ticket_price=$row3['ticket_price'];
      $destination_station=$row3['destination_station'];
      $departing_station=$row3['departing_station'];
      $departing_date=$row3['flight_departure_date'];
    }
    array_push($array,[$departing_date,$ticket_price,$destination_station,$departing_station,$ticket_id]);
    // CONTINUA AICI CE AI FACUT
    }
  }
get_tickets('inactive',$array_tickets_inactive);
get_tickets('active',$array_tickets_active);
get_tickets('refused',$array_tickets_refused);


?>