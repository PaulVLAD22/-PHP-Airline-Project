<html>

<head>
  <title>Vlavion Flights&#169;</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="https://www.flaticon.com/svg/static/icons/svg/2598/2598297.svg" type="image/x-icon">
  
  <?php
  //setup vars

  // failed sign in case
  $signinFailed = false;// base false
  $signinProblem = 'Username/Email Already Used'; //base message
  // failed log in case
  $loginFailed = false;// base false
  $loginProblem = 'Wrong Details'; // base message
  //failed forgot password 
  $forgotPasswordFailed=false;
  $forgotPasswordProblem='Wrong input';
  session_start();
  //
  if (isset($_SESSION['loggedIn']) && isset($_SESSION['adminLoggedIn'])) {
    header('location:/adminHome.php');
  }
  else if (isset($_SESSION['loggedIn'])){
    header('location:/home.php');
  }
   else {
    if (isset($_SESSION['signinFailed'])){
      $signinFailed = true;
      $signinProblem=$_SESSION['signinProblem'];
    }
    else if  (isset($_SESSION['loginFailed'])) {
      $loginFailed = true;
      $loginProblem=$_SESSION['loginProblem'];
    }
    else if (isset($_SESSION['forgotPasswordFailed'])){
      $forgotPasswordFailed=true;
      $forgotPasswordProblem=$_SESSION['forgotPasswordProblem'];
    }
  }
  //csrf protection
  $token_csrf = isset($_SESSION['delete_customer_token']) ? $_SESSION['delete_customer_token'] : "";
  if (!$token_csrf) {
      // generate token and persist for later verification
      // - in practice use openssl_random_pseudo_bytes() or similar instead of uniqid() 
      $token_csrf = md5(uniqid());
      $_SESSION['delete_customer_token']= $token_csrf;
  }

  ?>
  <style>
    a{
      font-size:4vw;
    }
    <?php
    include 'CSS/login.css';
    ?>
  </style>
  <script>
    // sign in failed case
    var signinFailed = '<?php echo $signinFailed; ?>';
    var signinProblem = '<?php echo $signinProblem ?>';
    // log in failed case
    var loginFailed = '<?php echo $loginFailed; ?>';
    var loginProblem = '<?php echo $loginProblem; ?>';
    //forgot password case
    var forgotPasswordFailed = '<?php echo $forgotPasswordFailed ?>';
    var forgotPasswordProblem = '<?php echo $forgotPasswordProblem ?>';
    var token_csrf = '<?php echo $token_csrf ?>';
    <?php
    include "JS/index.js";
    ?>
  </script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body onload="displayForm()">
  <div id="box-container">
    <div id="box-1">
      <div id="topBar">
        <h2>Join Now</h2>
      </div>
      <div id="sloganDiv">
        Depart Now
        <img id="logoDiv" src="https://www.flaticon.com/svg/static/icons/svg/2598/2598297.svg">
      </div>
    </div>
    <div id="box-2">
      <div id="companyNameDiv">
        Vlavion Flights&#169;
      </div>
      <div id="loginMenuDiv">
        <div id="loginMessageDiv">
        </div>
        <div id="loginFieldsDiv">
        </div>
        <button id="switchButton" onclick="switchLogin()"></button>
      </div>
    </div>
  </div>
  
</body>

</html>