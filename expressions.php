<?php

//IMPLICIT TYPE CONVERSION 
$x = "15" + 27;
echo $x; //42
echo "\n"; //*New line*

$t = "15" + TRUE; // 15 + 1 = 16

$u = "sam" + 27; // 0 + 27  INTEGER VALUE

//Order of evaluation is the same as all other programming languages

/*
String Concatinaion: (.)
Equality & Inequality same as Javascript with implicit type conversion
(=== !===) -> Equal WITHOUT type conversion
Ternary (? :)  If then else in a single line. 
Side-effect Assignment (+= -= .=)
*/

$x = 12;
$y = 15 + $x++; //y becomes (27) THEN x becomes 13) 
//Simpler: 
$x = 12;
$y = 15 + $x;
$x += 1;
// String concatination: automatically converts to string
$a = 'Hello ' . 'World!'; // Dot is a STRING OPERATOR
echo $a . "\n"; // Hello World (new line)

//False does not print out anything 
echo "Hi" . False;  // "Hi"

// .= OPERATOR: 
$out = "Hello";
$out .= " World";
echo $out; //"Hello world"


// Ternirary operator
$msg = 10 > 100 ? "true" : "not true";  //msg = not true

/*Division of integers converts to a floating point number if decimal:
    ex. 1 / 4 = .25
    */
?>
