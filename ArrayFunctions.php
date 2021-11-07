<?php
    // Sort commands for key => value arrays:
    $za = array(
        "name" => "Ethan",
        "age" => 16,
        "food" => "Pizza"
    )
    ksort($za); // Sorts by keys
    /* Result:
    "age" => 16,
    "food" => "Pizza",
    "name" => "Ethan
    */

    asort($za) // Sorts by values
    /* Result:
        "age" => 16
        "name" => "Ethan"
        "food" => "Pizza
    */
?>