var accountDetailsDisplaying = false;
var buyTicketsDisplaying = false;
var activeTicketsDisplaying = false;

array_tickets_active= eval(array_tickets_active);
array_tickets_inactive= eval(array_tickets_inactive);
array_tickets_refused= eval(array_tickets_refused);
console.log(array_tickets_refused);
console.log(array_tickets_inactive);
console.log(array_tickets_active);


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
    rightSide.innerHTML = "<div id='ticketsDiv'><h1>Active Tickets:</h1><div class='userTicketsDiv' id='activeTicketsDiv'></div><h1>Inactive Tickets:</h1><div class='userTicketsDiv' id='inactiveTicketsDiv'></div><h1>Refused Tickets:</h1><div class='userTicketsDiv' id='refusedTicketsDiv'></div><form action='Back-End/delete_expired_tickets.php' method='POST'><input id='expiredTicketsBtn' name='submit' type='submit' value='Delete expired tickets'></form></div>";
    for (let i=0;i<array_tickets_active.length;i++){//active tickets
      document.getElementById('activeTicketsDiv').innerHTML+="<span> "+array_tickets_active[i][0]+" price:"+array_tickets_active[i][1]+"$-from:"+array_tickets_active[i][2]+"-to:"+array_tickets_active[i][3]+"</span>";
    }
    for (let i=0;i<array_tickets_inactive.length;i++){//active tickets
      document.getElementById('inactiveTicketsDiv').innerHTML+="<span> "+array_tickets_inactive[i][0]+" price:"+array_tickets_inactive[i][1]+"$-from:"+array_tickets_inactive[i][2]+"-to:"+array_tickets_inactive[i][3]+"</span>";
    }
    for (let i=0;i<array_tickets_refused.length;i++){//active tickets
      document.getElementById('refusedTicketsDiv').innerHTML+="<span> "+array_tickets_refused[i][0]+" price:"+array_tickets_refused[i][1]+"$-from:"+array_tickets_refused[i][2]+"-to:"+array_tickets_refused[i][3]+"</span>";
    }
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
    if(first_name!=''){
      rightSide.innerHTML =
        "<div id='buyTicketDiv'><form><label for='departingStation'>Departing Station:</label><br><input type='text' id='departingStation' name='departingStation'><br><label for='destinationStation'>Destination Station:</label><br><input type='text' id='destinationStation' name='destinationStation'><br><label for='flightDate'>Flight Date</label><br><input type='date' id='fightDate' name='flightDate'><br><br><input type='submit' value='Search' class='submitbtn' onclick='openFlightsPage()'></form></div>";
    }else{
      rightSide.innerHTML ="<div id='displayDiv'>Complete your account details!</div>";
    }
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
       rightSide.innerHTML ="<div id='accountDetailsDiv'><form action='Back-End/completeDetails.php' method='POST'><label for='nationality'>Nationality<br><input type='text' id='nationality' name='nationality'><br><label for='identificationCode'>Identification Code:</label><br><input type='text' id='identificationCode' name='identificationCode'><br><label for='firstName'>First Name:</label><br><input type='text' id='firstName' name='firstName'><br><label for='lastName'>Last Name:</label><br><input type='text' id='lastName' name='lastName'><br><label for='phoneNumber'>Phone Number:</label><br><input type='text' id='phoneNumber' name='phoneNumber'><br><label for='dateOfBirth'>Date of Birth:</label><br><input type='date' id='dateOfBirth' name='dateOfBirth'><br><label for='socialStatus'>Social Status </label><select name='socialStatus'><option>Student</option><option>Retired</option><option>None</option></select><h3 id='failedLoginMessage'>"+completeDetailsProblem+"</h3><input type='submit' value='Save' class='submitbtn'></form></div> ";
      }else{
         rightSide.innerHTML="<div id='accountDetailsDiv'><form action='Back-End/completeDetails.php' method='POST'><label for='nationality'>Nationality<br><input type='text' id='nationality' name='nationality'><br><label for='identificationCode'>Identification Code:</label><br><input type='text' id='identificationCode' name='identificationCode'><br><label for='firstName'>First Name:</label><br><input type='text' id='firstName' name='firstName'><br><label for='lastName'>Last Name:</label><br><input type='text' id='lastName' name='lastName'><br><label for='phoneNumber'>Phone Number:</label><br><input type='text' id='phoneNumber' name='phoneNumber'><br><label for='dateOfBirth'>Date of Birth:</label><br><input type='date' id='dateOfBirth' name='dateOfBirth'><br><label for='socialStatus'>Social Status </label><select name='socialStatus'><option>Student</option><option>Retired</option><option>None</option></select><br><br><input type='submit' value='Save' class='submitbtn'></form></div> ";
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
