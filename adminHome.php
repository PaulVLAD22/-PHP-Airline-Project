<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin's Home</title>
  <style>
    <?php
    include 'CSS/adminHome.css';
    ?>
  </style>
</head>
<?php
session_start();
$username=$_SESSION['username'];
?>
<body>
  <div id="topBar">
    <?php
    echo '<h2 id="userGreeting">Hello ' . $username . '</h2>';
    ?>
    <form action="logout.php" method="post">
      <input type='submit' id='logOutBtn' value='LogOut'>
    </form>
  </div>
  <div id="validateTickets">Validate Tickets:</div>
  <div id="ticketsList">
    <form class="ticketRequest"><input disabled value='informatii bilet' class='ticketInfo'><div class='btnMenu'><input type='submit' value='Y' class='btnTicket'><input type='submit' value='X' class='btnTicket'></div></form>
  </div>
</body>
</html>