'NU STIU DACA O SA REUSESC DAR AS VREA, MAI INTAI SA VERIFIC DACA EXISTA VREUN CONT CU EMAILUL ACESTA,
DACA DA, ATUNCI II TRMIT EMAIL CU CEVA LINK DE RESETARE AL PAROLEI SAU USER-ULUI SAU CEVA DE GENUL'
<?php
use PHPMAILER\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
$configs = include('config.php');
session_start();
// resetting log in and sign in errors
unset($_SESSION['signinFailed']);
unset($_SESSION['loginFailed']);
//

if (isset ($_POST['emailInput'])){
  $email = $_POST['emailInput'];

  $invalidEmail = false;
  if (strpos($email,'@') == false || strpos($email,'.') ==false) {  
    $invalidEmail=true;
  }


  if (!$invalidEmail){ //check for all invalid inputs errors
    $dbservername = $configs['host'];
    $dbusername = $configs['username'];
    $dbpassword = $configs['password'];
    $dbName = $configs['dbname'];


    $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbName);

    if ($conn->connect_error)
      die("Connection failed: " . $conn->connect_error);

    $stmt = $conn->prepare("select * from passenger where email = ?");

    $stmt->bind_param('s', $email);

    $stmt->execute();
    $result = $stmt->get_result();

    $username = '';
    $token='';
    $correctAccount = false;


    while ($row = $result->fetch_assoc()) {
      $username = $row['username'];
      $token = $row['token'];
      $correctAccount = true;
      }
    //closing db
    $stmt->close();
    $conn->close();

    if ($correctAccount) {

    

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
      $mail->Subject = 'Here is the subject';
      $mail->Body    = 'Hi'+$username+' your token is : '+$token;

      $mail->send();
      echo 'Message has been sent';
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
      header('location:/index.php');
    }
    else{
      session_start();
      
      $_SESSION['forgotPasswordFailed']=true;
      $_SESSION['forgotPasswordProblem']='Wrong Email';
      header('location:/index.php');

    }

  }
  else{
    session_start();
    $_SESSION['forgotPasswordFailed']=true;

    if ($invalidEmail){
      $_SESSION['forgotPasswordProblem']='Invalid Email';
    }
    header('location:/index.php');
  }



}
else{
  session_start();
  $_SESSION['forgotPasswordFailed']=true;
  $_SESSION['forgotPasswordProblem']='Stop Playing';
}






?>