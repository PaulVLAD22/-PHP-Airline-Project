<?php
function validate_phone_number($phone)
{
     // Allow +, - and . in phone number
     $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
     // Remove "-" from number
     $phone_to_check = str_replace("-", "", $filtered_phone_number);
     // Check the lenght of number
     // This can be customized if you want phone number from a specific country
     if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 14) {
        return false;
     } else {
       return true;
     }
}
function validate_name($name){
  if(preg_match("/^([a-zA-Z' ]+)$/",$name))
    return true;
  else
    return false;
}
function validate_date($date) { 
  if (false === strtotime($date)) { 
      return false;
  } 
  list($year, $month, $day) = explode('-', $date); 
  if(checkdate($month, $day, $year)){
    $today = date("Y/m/d");
    list($yToday, $mToday, $dToday) = explode('/', $today); 
    if ($yToday>$year || ($yToday==$year && $mToday>$month) || ($yToday==$year && $month==$mToday && $dToday>$day)){
      return false;
    }
    else{
      return true;
    }

  }
  else
  return false;
}
?>