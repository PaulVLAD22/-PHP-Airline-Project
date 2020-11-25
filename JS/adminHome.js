
array_tickets= eval(array_tickets);

function load_tickets(){
  for (let i=0;i<array_tickets.length;i++){
    document.getElementById('ticketsList').innerHTML+='<form action="evaluate_ticket.php" method="post" class="ticketRequest"><input readonly value="Ticket: '+array_tickets[i][0]+'|" name="ticket_id_input" class="ticket_id_input"><input readonly value="'+array_tickets[i][1]+" "+array_tickets[i][2]+" - "+array_tickets[i][3]+"| Seat "+array_tickets[i][4]+"-"+array_tickets[i][5]+"-"+array_tickets[i][6]+'" class="ticketInfo" name="ticket_info"><div class="btnMenu"><input type="submit" value="Y" class="btnTicket" name="y_input"><input type="submit" value="X" class="btnTicket" name="x_input"></div></form>'
  }

}


//fa sa poti schimba statusul in accepted si daca se apasa pe X il sterge
