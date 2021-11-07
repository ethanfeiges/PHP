<?php

// use functions to reduce redundancy
// Built-in String functions:
echo strlen("num"); // 3
echo str_repeat("three ", 3); // three three three 
echo function_exists("array_combine"); // True;

//Define own function:
    function greet(){
        echo "Hello User";
    }
    greet();
    greet();


    // return value:
    function returnGreet(){
        return "Greetings";
    }
    print returnGreet() . ", Ethan";


    // arguments:
    // You pass in VALUES, not the variables
    function getNum($x){
        return $x + 10;
    }
    print getNum(20); // 30
    print getNum("10"); // 20


    // Arguments can have defaults
    function multiplyNum($x = 30){
        return $x * 2;
    }
    print multiplyNum(); // 60
    print getNum(10); // 20


    // Call by REFERENCE '&'
    function triple(&$y){
        $y *= 3;
    }
    $y = 3;
    triple($y);
    echo $y; // 9


    // All variables declared inside a function have their scope limited to their function. 
    // Functions cannot access any variables unless passed in as a reference

    // GLOBAL VARIABLE: (Be careful about "colliding" variables)
    function breakThrough(){
        global $val; // 'go find me the variable "$val"'
        $val = 100;
    }
    $val = 10; 
    breakThrough(); // changes variable $val
    echo $val; // 100

?>