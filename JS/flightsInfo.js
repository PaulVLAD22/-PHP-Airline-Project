
array_flights=eval(array_flights)
console.log(array_flights)

for (let i=0;i<array_flights.length-1;i++){
  for (let j=i+1;j<array_flights.length;j++){
    if (array_flights[i]!=null && array_flights[j]!=null)
      if (array_flights[i].companyName.trim()==array_flights[j].companyName.trim() && array_flights[i].arrivalTime.trim()==array_flights[j].arrivalTime.trim() && 
        array_flights[i].departingTime.trim()==array_flights[j].departingTime.trim() && array_flights[i].ticketPrice.trim()==array_flights[j].ticketPrice.trim()) {
          array_flights.splice(j,1)
        }
  }
}

function loadFlights(){
  if (array_flights.length==0){
    document.getElementById("flightsList").innerHTML+="No flights/Wrong input";
  }
  else
    for (let i=0;i<array_flights.length;i++){
      document.getElementById("flightsList").innerHTML+="<form action='Back-End/buyTicket.php' method='post'><input name='flightDepartureDate' value='"+flightDepartureDate+"' hidden><input name='departingStation' value='"+departingStation+"' hidden><input name='destinationStation' value='"+destinationStation+"' hidden><input name='companyName' readonly value='"+array_flights[i]['companyName']+"'><input name='ticketPrice' readonly value='"+array_flights[i]['ticketPrice']+"'><input name='departingTime' readonly value='"+array_flights[i]['departingTime']+"'><input name='arrivalTime' readonly value='"+array_flights[i]['arrivalTime']+"'><input type='submit' name='postButton' value='Buy Ticket'></form>"
    }
}