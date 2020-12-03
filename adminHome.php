<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin's Home</title>
  <?php
  include 'Back-End/get_tickets.php';
  ?>
  <style>
    <?php
    include 'CSS/adminHome.css';
    ?>
  </style>
  <script>
    var array_tickets='<?php echo json_encode($array_tickets);?>';
    <?php
    include "JS/adminHome.js";
    ?>
  </script>
</head>
<?php

$username=$_SESSION['username'];
?>
<body onload='load_tickets()'>
  <div id="topBar">
    <?php
    echo '<h2 id="userGreeting">Hello ' . $username . '</h2>';
    ?>
    <form action="Back-End/logout.php" method="post">
      <input type='submit' id='logOutBtn' value='LogOut'>
    </form>
  </div>
  <div id="validateTickets">Validate Tickets:</div>
  <div id="ticketsList">
  </div>
  <form action="Back-End/getAdminRaport.php" method='post'><input name='submit' type='submit' value='Download Raport' class='submitbtn'>
</body>
</html>