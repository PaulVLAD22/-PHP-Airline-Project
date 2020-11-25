var accountDetailsDisplaying = false;
var buyTicketsDisplaying = false;
var activeTicketsDisplaying = false;

function startTime() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds();
  h = checkTime(h);
  m = checkTime(m);
  s = checkTime(s);
  let clockTime = h + ":" + m + ":" + s;
  document.getElementById("digitalClock").innerHTML =
    "<h2>" + clockTime + "</h2>";
  var t = setTimeout(startTime, 500);
}
function checkTime(i) {
  if (i < 10) {
    i = "0" + i;
  } // add zero in front of numbers < 10
  return i;
}

function displayActiveTicket() {
  var rightSide = document.getElementById("box-2");
  if (activeTicketsDisplaying == false) {
    rightSide.innerHTML = "<p>Aici trebuie sa citesc dintr-o tabela din mysql Tickets informatii despre ticketele care au ca valoare la coloana username username-ul logat</p>";
    activeTicketsDisplaying = true;
  } else {
    rightSide.innerHTML = "<div id='displayDiv'>Choose Item</div>";
    activeTicketsDisplaying = false;
  }
  accountDetailsDisplaying = false;
  buyTicketsDisplaying = false;
}

function displayBuyTickets() {
  var rightSide = document.getElementById("box-2");
  if (buyTicketsDisplaying == false) {
    rightSide.innerHTML =
      "<div id='buyTicketDiv'><form><label for='departingStation'>Departing Station:</label><br><input type='text' id='departingStation' name='departingStation'><br><label for='destinationStation'>Destination Station:</label><br><input type='text' id='destinationStation' name='destinationStation'><br><label for='flightDate'>Flight Date</label><br><input type='date' id='fightDate' name='flightDate'><br><br><input type='submit' value='Search' class='submitbtn' onclick='openFlightsPage()'></form></div>";
    buyTicketsDisplaying = true;
  } else {
    rightSide.innerHTML = "<div id='displayDiv'>Choose Item</div>";
    buyTicketsDisplaying = false;
  }
  accountDetailsDisplaying = false;
  activeTicketsDisplaying = false;
}

function displayAccountDetails() {
  var rightSide = document.getElementById("box-2");
  if (accountDetailsDisplaying == false) {
    if (first_name!=''){ // display details 
      rightSide.innerHTML =
        "<div id='accountDetailsDiv'><label>Email:</label><h3>"+email+"</h3><label>First Name:</label><h3>"+first_name+"</h3><label>Last Name:</label><h3>"+last_name+"</h3>"+"<label>Phone Number:</label><h3>"+phone_number+"</h3><label>Social Status:</label><h3>"+social_status+"</h3><label>Date of Birth:</label><h3>"+date_of_birth+"</h3></div>";
    }
    else{   //display form to complete details
      if (completeDetailsFailed!=''){//error submitting
       rightSide.innerHTML ="<div id='accountDetailsDiv'><form action='completeDetails.php' method='POST'><label for='nationality'>Nationality<br><input type='text' id='nationality' name='nationality'><br><label for='identificationCode'>Identification Code:</label><br><input type='text' id='identificationCode' name='identificationCode'><br><label for='firstName'>First Name:</label><br><input type='text' id='firstName' name='firstName'><br><label for='lastName'>Last Name:</label><br><input type='text' id='lastName' name='lastName'><br><label for='phoneNumber'>Phone Number:</label><br><input type='text' id='phoneNumber' name='phoneNumber'><br><label for='dateOfBirth'>Date of Birth:</label><br><input type='date' id='dateOfBirth' name='dateOfBirth'><br><label for='socialStatus'>Social Status </label><select name='socialStatus'><option>Student</option><option>Retired</option><option>None</option></select><h3 id='failedLoginMessage'>"+completeDetailsProblem+"</h3><input type='submit' value='Save' class='submitbtn'></form></div> ";
      }else{
         rightSide.innerHTML="<div id='accountDetailsDiv'><form action='completeDetails.php' method='POST'><label for='nationality'>Nationality<br><input type='text' id='nationality' name='nationality'><br><label for='identificationCode'>Identification Code:</label><br><input type='text' id='identificationCode' name='identificationCode'><br><label for='firstName'>First Name:</label><br><input type='text' id='firstName' name='firstName'><br><label for='lastName'>Last Name:</label><br><input type='text' id='lastName' name='lastName'><br><label for='phoneNumber'>Phone Number:</label><br><input type='text' id='phoneNumber' name='phoneNumber'><br><label for='dateOfBirth'>Date of Birth:</label><br><input type='date' id='dateOfBirth' name='dateOfBirth'><br><label for='socialStatus'>Social Status </label><select name='socialStatus'><option>Student</option><option>Retired</option><option>None</option></select><br><br><input type='submit' value='Save' class='submitbtn'></form></div> ";
       }
    }
    accountDetailsDisplaying = true;
  } else {
    rightSide.innerHTML = "<div id='displayDiv'>Choose Item</div>";
    accountDetailsDisplaying = false;
  }
  activeTicketsDisplaying = false;
  buyTicketsDisplaying = false;
}

function showFlightsPage() {
  // open html page with info from a site with all flights from a company
}

function openFlightsPage() {  // VA FI INLOCUIT DE UN FISIER PHP CARE VA DA CA POST statia plecare,destinatia,data
  window.open('flightsInfo.php');
  // display on right side (box-2 div) all flights information
}
