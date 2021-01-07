<?php
{
  session_start();
  if ($_SERVER['REQUEST_METHOD']=="POST"){
  $departingStation=$_POST['departingStation'];
  $destinationStation=$_POST['destinationStation'];
  $flightDate=$_POST['flightDate'];
  $_SESSION['buyTicketProblem']='';
  if (strtotime($_POST['flightDate'])<strtotime('now') || !($_POST['flightDate'])){
    $_SESSION['buyTicketsProblem']='Invalid Date';
    header('location:/home.php');
  }
  if ($departingStation==$destinationStation){
    $_SESSION['buyTicketsProblem']="Cannnot go to the same station";
    header('location:/home.php');
  }
  }
  else if ($_SERVER['REQUEST_METHOD']=="GET"){
    $departingStation=$_GET['departingStation'];
    $destinationStation=$_GET['destinationStation'];
    $flightDate=$_GET['flightDate'];
  }
  $departingStation=str_replace(" ","-",$departingStation);
  $destinationStation=str_replace(" ","-",$destinationStation);

  error_reporting(E_ERROR | E_PARSE);

  

  $departing_times=[];
  $arrival_times=[];
  $company_names=[];
  $ticket_prices=[];
  include ('Back-End/simple_html_dom.php');
  // echo "https://www.kayak.com/flights/".$departingStation."-".$destinationStation."/".$flightDate."/".$flightDate."?sort=bestflight_a";
  $html1 = file_get_html("https://www.kayak.com/flights/".$departingStation."-".$destinationStation."/".$flightDate."/".$flightDate."?sort=bestflight_a");
  $html2 = file_get_html("https://www.kayak.com/flights/".$departingStation."-".$destinationStation."/".$flightDate."/".$flightDate."?sort=bestflight_a");
  $html = file_get_html("https://www.kayak.com/flights/".$departingStation."-".$destinationStation."/".$flightDate."/".$flightDate."?sort=bestflight_a");
  try{
    $list = $html->find('div[class="section times"]');
    for ($i=0;$i<sizeof($list);$i=$i+2){
      $list_array = $list[$i]->find("span");
      array_push($departing_times,$list_array[0]->plaintext);
      array_push($arrival_times,$list_array[4]->plaintext);
      $ar = $list[$i]->find("div");
      array_push($company_names,$ar[1]);
    }
    $a = $html->find("div[class='booking']");
    for ($i=0;$i<sizeof($a);$i++){
      try{
        $txt= $a[$i]->find("span")[0]->find("span")[0];
        if ($txt!=null){
          array_push($ticket_prices,$txt);
        }
      }catch(Error $e){
      }
    }
  }catch(Error $e){

  }
  $flight_details=[];
  for ($i=0;$i<sizeof($departing_times);$i++){
    $array_temp=array();
    $array_temp['departingTime']=$departing_times[$i];
    $array_temp['arrivalTime']=$arrival_times[$i];
    $array_temp['companyName']=$company_names[$i]->plaintext;
    $array_temp['ticketPrice']=$ticket_prices[$i]->plaintext;
    array_push($flight_details,$array_temp);
  }
  $flight_details = array_intersect_key($flight_details, array_unique(array_map('serialize', $flight_details)));
  // for ($i=0;$i<sizeof($flight_details);$i++){
  //   echo $flight_details[$i]['departingTime'];
  //   echo $flight_details[$i]['arrivalTime'];
  //   echo $flight_details[$i]['companyName'];
  //   echo $flight_details[$i]['ticketPrice'];
  // }
  
  //Adaugam in baza de date
  $configs = include('Back-End/config.php');
  $dbservername = $configs['host'];
  $dbusername = $configs['username'];
  $dbpassword = $configs['password'];
  $dbName = $configs['dbname'];
  $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbName);
  if ($conn->connect_error)
      die("Connection failed: " . $conn->connect_error);
  $sql = "select count(*) from flight where flight_departure_date=?";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("s",$flightDate);
  $stmt->execute();
  $result = $stmt->get_result();
  $flightsNr=0;
  while ($row = $result->fetch_assoc()){
    $flightsNr=$row['count(*)'];
  }
  if ($flightsNr==0){
    // for ($i=0;$i<sizeof($flight_details);$i++){
    //   echo $flight_details[$i]['departingTime'];
    //   echo $flight_details[$i]['arrivalTime'];
    //   echo $flight_details[$i]['companyName'];
    //   echo $flight_details[$i]['ticketPrice'];
    // }
    for ($i=0;$i<sizeof($flight_details);$i++){
      $sql = "insert into flight (flight_departure_date,airline_name,departing_station,destination_station,arrival_time,total_seats,ticket_price,last_empty_seat,departing_time) values (?,?,?,?,?,60,?,0,?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sssssss",$flightDate,$flight_details[$i]['companyName'],$departingStation,$destinationStation,$flight_details[$i]['arrivalTime'],$flight_details[$i]['ticketPrice'],$flight_details[$i]['departingTime']);
      $stmt->execute();
    }
  }else{
    $sql="select * from flight where flight_departure_date=?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("s",$flightDate);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()){
      if($row['airline_name']!==null){
        $array_temp=array();
        $array_temp['companyName']=$row['airline_name'];
        $array_temp['departingTime']=$row['departing_time'];
        $array_temp['arrivalTime']=$row['arrival_time'];
        $array_temp['ticketPrice']=$row['ticket_price'];
        array_push($flight_details,$array_temp);
      }
    }
    $flight_details = array_map("unserialize", array_unique(array_map("serialize", $flight_details)));
  }
  if (sizeof($flight_details)==0){
    $_SESSION['buyTicketsProblem']='No flights';
    header('location:home.php');
  }
  else{
    $_SESSION['buyTicketsProblem']='';
  }
  
}

  
// FA FRONT-END -UL CU DATELE DE PE SITE.
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flighs Info</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
   integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <style>
  <?php
  include 'CSS/flightsInfo.css';
  ?>
  </style>
  <script>
    var departingStation='<?php echo $departingStation ?>';
    var destinationStation ='<?php echo $destinationStation ?>';
    var flightDepartureDate='<?php echo $flightDate ?>';
    var array_flights='<?php echo json_encode($flight_details) ?>';
    <?php
    include "JS/flightsInfo.js";
    ?>
  </script>
</head>
<body onload="loadFlights()">
<a href="home.php">Back to Home</a>
<h2 class=" d-flex flex-column align-items-center justify-content-center"><?php echo $flightDate." ".$departingStation." ".$destinationStation; ?></h2>
<br>
<div class="d-flex flex-column justify-content-center align-items-center" id="flightsList">
</div>
<a href="checkoutPage.php">Checkout Page</a>
<h2><?php echo $_SESSION['buyTicketProblem'];?></h2>
</body>
</html>
