var loginBool = 0; // base case log in is showed
if (signinFailed != "") {
  loginBool = 1; // if sign is was wrong display sign in on load
} else if (loginFailed != "") {
  loginBool = 0; //if log in was wrong display log in on load
}

function displayForm(){// decides which form to show
  if (forgotPasswordFailed!='')
    displayForgotPassDiv();
  else
    switchLogin();
}


function switchLogin() {
  if (loginBool == 1) {
    //if loggin already displaying DISPLAY SIGNIN
    document.getElementById("switchButton").innerHTML = "Log in"; // switch login type
    var signInHtml = "";
    if (signinFailed == "") {
      signInHtml =
        "<form action='Back-End/signin.php' method='POST'>        <label for='usernameInput'>Enter Username:</label><br>        <input type='text' id='usernameInput' name='usernameInput' placeholder='Username'><br>        <label for='passwordInput'>Enter Password:</label><br>        <input type='password' id='passwordInput' name='passwordInput' placeholder='Password'><br><label for='confirmpass'>Confirm Password:</label><br> <input type='password' id='confirmpass' name='confirmpass' placeholder='Password'><br>  <label for='emailInput'>Enter Email:</label><br>    <input type='email' id='emailInput' name='emailInput' placeholder='Email'><br><br>   <input type='submit' value='Submit' class='submitBtn'>   </form>";
    } else {
      signInHtml =
        "<form action='Back-End/signin.php' method='POST'>        <label for='usernameInput'>Enter Username:</label><br>        <input type='text' id='usernameInput' name='usernameInput' placeholder='Username'><br>        <label for='passwordInput'>Enter Password:</label><br>        <input type='password' id='passwordInput' name='passwordInput' placeholder='Password'><br><label for='confirmpass'>Confirm Password:</label><br> <input type='password' id='confirmpass' name='confirmpass' placeholder='Password'><br>  <label for='emailInput'>Enter Email:</label><br>    <input type='email' id='emailInput' name='emailInput' placeholder='Email'><br><h3 id='failedSignUpMessage'>" +
        signinProblem +
        "</h3><br><input type='submit' value='Submit' class='submitBtn'>   </form>";
      signinProblem='';
    }
    document.getElementById("loginFieldsDiv").innerHTML = signInHtml; //changing input fields
    document.getElementById("loginMessageDiv").innerHTML = "Sign Up"; //changing login message
    loginBool = 0;
  } else {
    // if signup already displaying DISPLAY LOGIN
    document.getElementById("switchButton").innerHTML = "Sign in"; // switch login type
    var loginHtml = "";
    if (loginFailed == "") {
      loginHtml =
        "<form action='Back-End/login.php' method='POST'>        <label for='usernameInput'>Enter Username:</label><br>        <input type='text' id='usernameInput' name='usernameInput' placeholder='Username'><br>        <label for='passwordInput'>Enter Password:</label><br>        <input type='password' id='passwordInput' name='passwordInput' placeholder='Password'><br><a onclick='displayForgotPassDiv()'>Forgot password?</a><br><br>        <input type='submit' value='User' class='submitBtn' name='loginPassanger'><input type='submit' value='Admin' class='submitBtn' name='loginAdmin'>       </form>";
    } else {
      loginHtml =
        "<form action='Back-End/login.php' method='POST'>        <label for='usernameInput'>Enter Username:</label><br>        <input type='text' id='usernameInput' name='usernameInput' placeholder='Username'><br>        <label for='passwordInput'>Enter Password:</label><br>        <input type='password' id='passwordInput' name='passwordInput' placeholder='Password'><br><a onclick='displayForgotPassDiv()'>Forgot password?</a><br><h3 id='failedLoginMessage'>" +
        loginProblem +
        "<br><input type='submit' value='Submit' class='submitBtn' name='loginPassanger'><input type='submit' value='Admin' class='submitBtn' name='loginAdmin'>     </form>";
        loginProblem='';
    }
    document.getElementById("loginFieldsDiv").innerHTML = loginHtml; //changing input fields
    document.getElementById("loginMessageDiv").innerHTML = "Log In"; //changing login message
    loginBool = 1;
  }
}
function displayForgotPassDiv() {
  document.getElementById("switchButton").innerHTML = "Log in";
  let loginFieldsDiv = document.getElementById("loginFieldsDiv");
  var forgotPassHtml='';
  if (forgotPasswordFailed!=''){//failed 
    forgotPassHtml =
      "<form action='Back-End/forgotPass.php' method='post'><label for='emailInput'>Enter Email:</label><br><input type='email' name='emailInput' placeholder='user@domain.com'><br><h3 id='failedLoginMessage'>"+forgotPasswordProblem+"</h3><br><input type='submit' value='Submit' class='submitBtn'></form>";
  }
  else{
    forgotPassHtml =
    "<form action='Back-End/forgotPass.php' method='post'><label for='emailInput'>Enter Email:</label><br><input type='email' name='emailInput' placeholder='user@domain.com'><br><br><input type='submit' value='Submit' class='submitBtn'></form>";
  }
    loginFieldsDiv.innerHTML = forgotPassHtml;
}
