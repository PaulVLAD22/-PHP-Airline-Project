<?php
use PHPMAILER\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
$configs = include('config.php');
session_start();

//
unset($_SESSION['loginFailed']);
unset($_SESSION['forgotPasswordFailed']);
// resetting login Problems 
// verifica si altele
if (isset ($_POST["usernameInput"]) && isset($_POST["passwordInput"])
&& isset($_POST["confirmpass"]) && isset($_POST["emailInput"])){
  $username = $_POST["usernameInput"];
  $password = $_POST["passwordInput"];
  $confirmpass = $_POST['confirmpass'];
  $email = $_POST["emailInput"];
  $accountType = '';

  $uncompletedFields = false;
  $differentPasswords = false;
  $usedIllegalCharacters=false;

  if (strlen($username) == 0 || strlen($password) == 0 ||
  strlen($confirmpass) == 0 || strlen($email) == 0)
    $uncompletedFields = true;
  if ($password != $confirmpass)
    $differentPasswords = true;

  if (!$uncompletedFields) {
    $atIndex = 0;
    while ($email[$atIndex] != '@') {
      $atIndex++;
    }

    if ($atIndex + 5 <= strlen($email)) {
      if (substr($email, $atIndex + 1, 5) == 'gmail') {
        $accountType = 'gmail';
      } else if (substr($email, $atIndex + 1, 5) == 'yahoo') {
        $accountType = 'yahoo';
      } else {
        $accountType = 'basic';
      }
    } else {
      $accountType = 'basic';
    }
  }
  if (!(ctype_alnum($usedIllegalCharacters) || !(ctype_alnum($password)) || 
      !(ctype_alnum($email)))){
    $usedIllegalCharacters=true;
  }
  
  //check for all invalid inputs errors below
  if (!$uncompletedFields && !$differentPasswords && !$usedIllegalCharacters) {
    function generateRandomString($length = 10) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
  }
  $dbservername = $configs['host'];
  $dbusername = $configs['username'];
  $dbpassword = $configs['password'];
  $dbName = $configs['dbname'];
  

    $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbName);

    if ($conn->connect_error)
      die("Connection failed: " . $conn->connect_error);

    
    $token = generateRandomString();

    $sql = "INSERT INTO passenger (username,password,email,date_created,status,token) values(?, ?, ?, SYSDATE(),'inactive',?);";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ssss",$username,password_hash($password,PASSWORD_BCRYPT),$email,$token);

    if ($stmt->execute() === TRUE) {
      header('location:/index.php');
      $mail = new PHPMailer(true);
      try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'tls://smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'vlavionflights@gmail.com';                     // SMTP username
        $mail->Password   = 'parola34007';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
  
        //Recipients
        $mail->setFrom('vlavionflights@gmail.com', 'Mailer');
        $mail->addAddress($email);     // Add a recipient
        $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Sign Up';
        $mail->Body    = 'Hi '.$username.' your token is : '.$token;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
  
        $mail->send();
        echo 'Message has been sent';
      } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }

      $_SESSION['signinProblem']='';
      //save 
      
      //closing db
      $stmt->close();
      $conn->close();
    } else {
      session_start();
      $_SESSION['signinFailed'] = true;
      $_SESSION['signinProblem']='Username already used';

      header('location:/index.php');
      //closing db
      $stmt->close();
      $conn->close();
    }
  } else {
    session_start();
    
    $_SESSION['signinFailed'] = true;

    if ($differentPasswords) {
      $_SESSION['signinProblem'] = 'Different Passwords';
    }

    if ($usedIllegalCharacters){
      $_SESSION['signinProblem'] = 'Used Illegal Characters';
    }

    if ($uncompletedFields) {
      $_SESSION['signinProblem'] ='Uncompleted Fields'; 
    }


    header('location:/index.php');
    
  }
}
else{
  session_start();
  
  $_SESSION['signinFailed'] = true;
  $_SESSION['signinProblem']= 'Stop Playing';
  header('location:/index.php');
}



?>
