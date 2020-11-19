<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Activate Account</title>
  <style>
    <?php
    include 'CSS/activatePage.css';
    ?>

  </style>
</head>
<body>

<?php


//fa design la pagina asta
session_start();
if (!isset($_SESSION['email'])){
  die('Error');
}
$email = $_SESSION['email'];
?>

<form action="activate.php" method="POST"><label for="tokenInput">Enter token for <?php echo $email;?></label><input type="text" name="tokenInput"><input type="submit" value="submit"> </form>

</body>
</html>
