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
session_unset();
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
    $correctAccount = false;
    $token='';

    while ($row = $result->fetch_assoc()) {
        $token=$row['token'];
        $correctAccount=true;
      }
    //closing db
    $stmt->close();
    $conn->close();

    if ($correctAccount==true) {
      $_SESSION['email']=$email;
      header('location:../resetPassTokenPage.php');
      $mail = new PHPMailer(true);
      try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'tls://smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'vlavionflights@gmail.com';                     // SMTP username
        $mail->Password   = $configs['emailPass'];                            // SMTP password
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
        $mail->Body    = 'Hi your token is : '.$token;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
  
        $mail->send();
        echo 'Message has been sent';
      } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
  }
  else{
    session_start();
    $_SESSION['forgotPasswordFailed']=true;
    $_SESSION['forgotPasswordProblem']='Invalid Email';
    if ($invalidEmail){
      $_SESSION['forgotPasswordProblem']='Invalid Email';
    }
    header('location:../index.php');
  }
}
else{
  
  $_SESSION['forgotPasswordFailed']=true;
  $_SESSION['forgotPasswordProblem']='Stop Playing';
  header('location:../index.php');
}
}
else{
  
  $_SESSION['forgotPasswordFailed']=true;
  $_SESSION['forgotPasswordProblem']='Stop Playing';
  header('location:../index.php');
}
?>