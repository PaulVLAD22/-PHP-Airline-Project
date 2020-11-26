<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Activate Account</title>
  <style>
    <?php
    include 'CSS/resetPassPage.css';
    ?>
  </style>
  <?php
  include 'Back-End/getUsername.php';
  ?>
</head>
<body>

<?php
//fa design la pagina asta
if (!isset($_SESSION['email'])){
  die('Error');
}

$email = $_SESSION['email'];
$username =$_SESSION['username'];
?>
<h2><?php echo "Reset Password for :".$email?></h2>
<h2><?php echo "Username: ".$username?></h2>
<form action='Back-End/resetPass.php' method='POST'><label for='passwordInput'>New password:</label><input type='password' name='passwordInput'><label for='passwordConfirmInput'>Confirm new password:</label><input type='password' name='passwordConfirmInput'><input type='submit' value='Submit'></form>
<button onclick=openIndex()>SKIP</button>
</body>

<script>
function openIndex(){
  window.open('index.php');
}
</script>
</html> 