<?php 
    echo "Guess a number between 0-100";
    echo "\r\n";
    $val = $_GET["guess"];
    $random = rand(0, 100);
    if ($val < $random){
        echo "Too low ";
    }
    elseif ($val > $random){
        echo "Too high ";
    }
    else{
        echo "You got the correct number: " .$random;
    }
    if($_GET["quit"] == "y"){
        echo "The correct answer was: " .$random;
    }
?>