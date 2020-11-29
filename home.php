<html>

<head>
  <?php
  session_start();
  $completeDetailsFailed=false;
  $completeDetailsProblem='Submit Problem';
  if (!(isset($_SESSION['loggedIn']))) {
    die('Failed login');
  }
  if (isset($_SESSION['completeDetailsFailed'])){
    $completeDetailsFailed=true;
    $completeDetailsProblem=$_SESSION['completeDetailsProblem'];
  }
  include "Back-End/get_user_tickets.php";
  $user = $_SESSION['username'];
  $email = $_SESSION['email'];
  $first_name = $_SESSION['first_name'];
  $last_name = $_SESSION['last_name'];
  $date_of_birth = $_SESSION['date_of_birth'];
  $social_status = $_SESSION['social_status'];
  $phone_number = $_SESSION['phone_number'];
  
  echo '<title>Vlavion ' . $user . '</title>';
  ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="https://www.flaticon.com/svg/static/icons/svg/2598/2598297.svg" type="image/x-icon">
  <style>
    <?php
    include 'CSS/home.css';
    ?>
  </style>

  <script>
    var email = '<?php echo $email; ?>';
    var first_name = '<?php echo $first_name ?>';
    var last_name = '<?php echo $last_name ?>';
    var date_of_birth = '<?php echo $date_of_birth ?>';
    var phone_number = '<?php echo $phone_number ?>';
    var social_status = '<?php echo $social_status ?>';
    var completeDetailsFailed='<?php echo $completeDetailsFailed ?>';
    var completeDetailsProblem ='<?php echo $completeDetailsProblem ?>';
    // tickets
    var array_tickets_inactive='<?php echo json_encode($array_tickets_inactive) ?>';
    var array_tickets_active='<?php echo json_encode($array_tickets_active) ?>';
    var array_tickets_refused='<?php echo json_encode($array_tickets_refused) ?>';
    <?php
    include "JS/home.js";
    ?>
  </script>
</head>

<body onload="startTime()">
  <div id="topBar">
    <?php
    $user = $_SESSION['username'];
    echo '<h2 id="userGreeting">Hello ' . $user . '|</h2>';
    ?>
    <h2 id="digitalClock"></h2>
    <form action='Back-End/logout.php'>
      <input type='submit' id="logOutBtn" value='Log Out'>
    </form>
  </div>
  <div id="box-container">
    <div id="box-1">
      <div id="ButtonMenu">
        <button class="menubtn" id="activeTicketsBtn" onclick="displayActiveTicket()">Active Tickets</button>
        <button class="menubtn" id="buyTicketsBtn" onclick="displayBuyTickets()">Buy Tickets</button>
        <button class="menubtn" id="accDetailsBtn" onclick="displayAccountDetails()">Account Details</button>
      </div>
    </div>
    <div id="box-2">
      <div id="displayDiv">
        Choose Item
      </div>
    </div>
  </div>
</body>

</html>