<?php
$configs = include('config.php');
session_start();
$username=$_SESSION['username'];
// fa faza cu isset
require_once 'functions.inc.php';
if (isset($_POST['identificationCode']) && isset($_POST['firstName']) &&
isset($_POST['lastName']) && isset($_POST['phoneNumber']) &&
isset($_POST['socialStatus']) && isset($_POST['dateOfBirth']) && isset($_POST['nationality'])){
  $identification_code = $_POST["identificationCode"];
  $first_name = $_POST["firstName"];
  $last_name = $_POST['lastName'];
  $phone_number = $_POST["phoneNumber"];
  $social_status = $_POST["socialStatus"];
  $input_date_of_birth=$_POST['dateOfBirth'];
  $nationality= $_POST['nationality'];
  $date_of_birth=date("Y-m-d",strtotime($input_date_of_birth));
  
  $uncompletedFields = false;
  $phoneNumberWrong=false;
  
  if (strlen($identification_code) == 0 || strlen($first_name) == 0 ||
  strlen($last_name) == 0 || strlen($phone_number) == 0 
  || strlen($date_of_birth) == 0 || strlen($social_status) == 0)
    $uncompletedFields = true;

  if (validate_phone_number($phone_number)!=true){
    $phoneNumberWrong=true;
  }
  

    // mai fa si verificarea cu ctype_alumn

  if (!$uncompletedFields) {
    if(!$phoneNumberWrong){
      if(!validate_name($first_name) || validate_name($last_name)){
        if (!validate_date($input_date_of_birth)){
          $dbservername = $configs['host'];
          $dbusername = $configs['username'];
          $dbpassword = $configs['password'];
          $dbName = $configs['dbname'];

          
          $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbName);

          if ($conn->connect_error)
            die("Connection failed: " . $conn->connect_error);

          $sql = "UPDATE passenger set nationality=".$nationality." identification_code='".$identification_code."',phone_number='".$phone_number."',first_name='".$first_name."',last_name='".$last_name."',date_of_birth='".$date_of_birth."',social_status='".$social_status."' where username='".$username."';";
          
          if ($conn->query($sql) === TRUE) {
            session_start();
            //save 
            $_SESSION['first_name']=$first_name;
            $_SESSION['last_name']=$last_name;
            $_SESSION['date_created']=$date;
            $_SESSION['date_of_birth']=$date_of_birth;
            $_SESSION['social_status']=$social_status;
            $_SESSION['phone_number']=$phone_number;
            $_SESSION['nationality']=$nationality;
            //
            $_SESSION['loggedIn'] = true;
            header('location:/home.php');
          }
        }else{
          session_start();
          $_SESSION['completeDetailsFailed']=true;
          $_SESSION['completeDetailsProblem']='Invalid Date';
          header('location:/home.php');
        }
      }else{
        session_start();
        $_SESSION['completeDetailsFailed']=true;
        $_SESSION['completeDetailsProblem']='Firstname/Lastname wrong';
        header('location:/home.php');
      }
    }    
    else{
      session_start();
    $_SESSION['completeDetailsFailed']=true;
    $_SESSION['completeDetailsProblem']='Phone Number Wrong';
    header('location:/home.php');
      
      // uncompleted fields, send a message under the fields
    }
  }
  else{
    session_start();
      $_SESSION['completeDetailsFailed']=true;
      $_SESSION['completeDetailsProblem']='Uncompleted fields';
      header('location:/home.php');

  }
}
else{
  session_start();
  $_SESSION['completeDetailsFailed']=true;
  $_SESSION['completeDetailsProblem']='Stop Playing';
  header('location:/home.php');
}



?>