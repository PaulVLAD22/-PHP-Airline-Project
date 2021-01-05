<?php

if (isset ($_POST['numberInput'])){
  if ($_POST['numberInput']<1){
    die('Wrong Input');
  }
  $numar = $_POST['numberInput'];
}
else{
  die('Wrong Input');
}
$r=$numar;
$c=$numar;

function spiralFill($m, $n, &$a) 
{ 
    // Initialize value to be filled  
    // in matrix 
    $val = 1; 
  
    /* k - starting row index 
       m - ending row index 
       l - starting column index 
       n - ending column index */
    $k = 0; 
    $l = 0; 
    while ($k < $m && $l < $n) 
    { 
        /* Print the first row from 
        the remaining rows */
        for ($i = $l; $i < $n; ++$i) 
            $a[$k][$i] = $val++; 
  
        $k++; 
  
        /* Print the last column from 
        the remaining columns */
        for ($i = $k; $i < $m; ++$i) 
            $a[$i][$n - 1] = $val++; 
        $n--; 
  
        /* Print the last row from  
        the remaining rows */
        if ($k < $m) 
        { 
            for ($i = $n - 1; $i >= $l; --$i) 
                $a[$m - 1][$i] = $val++; 
            $m--; 
        } 
  
        /* Print the first column from 
           the remaining columns */
        if ($l < $n) 
        { 
            for ($i = $m - 1; $i >= $k; --$i) 
                $a[$i][$l] = $val++; 
            $l++; 
        } 
    } 
}
spiralFill($r, $c, $a);
for ($i = 0; $i < $r; $i++) 
{ 
    for ($j = 0; $j < $c; $j++) 
    { 
        echo ($a[$i][$j]); 
        echo (" "); 
    } 
    echo "<br>";
} 


?>