<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flighs Info</title>
  <style>
  <?php
  include 'CSS/flightsInfo.css';
  ?>
  </style>
</head>
<body>
<?php
session_start();
$url = file_get_contents('https://www.kayak.com/flights/Bucharest-London/2020-12-18/2020-12-25?sort=bestflight_a');
$resultsContent=explode('<div class="resultsContainer">',$url);
$resultsList = explode('class="resultsList',$resultsContent[1]);
$resultsList1 = explode('div id="HIHCO5uh19-1"',$resultsList[1]);
echo $resultsList1;
?>
AICI VA FI O LISTA CU ZBORURI SI LOCURI RAMASE, IAR USERII VOR PUTEA APASA PE UN BUTON
LANGA SI SA CUMPERE BILETUL CARE VA TRIMITE O CERERE CATRE UN ALT UTILIZATOR CARE VERIFICA DACA MAI SUNT LOCURI
<a href="checkoutPage.php">Checkout Page</a>
<a href="home.php">Back to Home</a>
</body>
</html>
