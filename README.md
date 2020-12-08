# DAW-PHP

<h1>Tema1:</h1>

User-ul normal se inregistreaza, primeste pe email un token pe care trebuie sa l bage dupa ce se logheaza. Apoi este dus la pagina home unde isi completteaza datele si dupa intra pe o pagina
unde sunt expuse mai multe bilete si apoi este dus pe o pagina de checkout unde isi baga cardul.

Adminii pot vedea lista cu ticketele pe care vor sa le cumpere oamenii si le schimba statusul de pe inactiv pe activ, confirmandu-le.
<img src="https://i.imgur.com/ZdZDf2v.png">

host : https://vlavion-flights.herokuapp.com/

<h1>Tema2:</h1>

diagrama : https://dbdiagram.io/d/5f9fdd383a78976d7b7a1d41

<img src="https://i.imgur.com/9fu3Wj4.png">


Daca faceti cont nou va merge deoarece trebuie sa bagati un token pe care am reusit sa l fac sa l trimita pe emailul bagat la sign up.

<h1>Tema3:</h1>
Elementele de protectie sunt :
<li>SQL INJECTION - stmt->prepare , bind_param (asemanatoare cu mysql_real_escape) </li>
<li>XRSF - token specific to session</li>
<li>XSS - htmlspecialchars(input)</li>
