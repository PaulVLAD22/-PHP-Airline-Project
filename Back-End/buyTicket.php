<?php
session_start();
$username=$_SESSION['username'];
$passenger_id=0;
$_SESSION['buyTicketProblem']='';

if (isset($_POST['postButton'])){
  $departingStation=$_POST['departingStation'];
  $destinationStation=$_POST['destinationStation'];
  $flightDate=$_POST['flightDepartureDate'];
  $companyName=$_POST['companyName'];
  $ticketPrice=$_POST['ticketPrice'];
  $departingTime=$_POST['departingTime'];
  $arrivalTime=$_POST['arrivalTime'];

  echo $departingStation;
  echo $destinationStation;

  $configs = include('config.php');
  $dbservername = $configs['host'];
  $dbusername = $configs['username'];
  $dbpassword = $configs['password'];
  $dbName = $configs['dbname'];

  $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbName);

  if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);
  $cumparat_corect=1;


  //get flight_id by data and insert it into user with username=$username
  //get user_id
  $sql = "select * from passenger where username=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_assoc()) {
    $passenger_id=$row['passenger_id'];
  }
  $flight_id=0;
  $last_empty_seat=0;
  $sql = "select * from flight where flight_departure_date=? and airline_name=? and ticket_price=? and departing_time=? and arrival_time=? and destination_station=? and departing_station=?;";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssssss", $flightDate,$companyName,$ticketPrice,$departingTime,$arrivalTime,$destinationStation,$departingStation);
  
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_assoc()) {
    $flight_id=$row['flight_id'];
    $last_empty_seat=$row['last_empty_seat'];
  }
  if($last_empty_seat==59){
    $cumparat_corect=0;
    $_SESSION['buyTicketProblem']='No more seats';
    header('location:../flightsInfo.php?departingStation='.$departingStation."&destinationStation=".$destinationStation."&flightDate=".$flightDate);
  }
  else{
    $sql="select count(*) from ticket where passenger_id=? and flight_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $passenger_id,$flight_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        if ($row['count(*)']!==0){
          $cumparat_corect=0;
          $_SESSION['buyTicketProblem']='You already bought a ticket for this flight';
          header('location:../flightsInfo.php?departingStation='.$departingStation."&destinationStation=".$destinationStation."&flightDate=".$flightDate);
        }
    }
    //
    $sql="insert into ticket (passenger_id,flight_id,seat,status) values (?,?,?,'inactive')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $passenger_id,$flight_id,$last_empty_seat);
    $stmt->execute();
  }
  if ($cumparat_corect===1){
    $_SESSION['buyTicketProblem']='You just bought a ticket';
    header('location:../flightsInfo.php?departingStation='.$departingStation."&destinationStation=".$destinationStation."&flightDate=".$flightDate);
  }
  //check if can insert ticket 
  //insert ticket
  // $sql = "select * from flight where flight_departure_date=? and airline_name=? and ticket_price=? and departing_time=? and arrival_time=?";
  // $stmt = $conn->prepare($sql);
  // $stmt->bind_param("sssss", $flightDate,$companyName,$ticketPrice,$departingTime,$arrivalTime);
  // $stmt->execute();
  

}


?>