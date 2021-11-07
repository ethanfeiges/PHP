<?php
// Associative arrays: Index by numbers or key => value pairs
   
    // Index by numbers:
    $stuff = array("My", "Stuff");
    echo $stuff[1], "\n"; // "Stuff"


    // Key => value:
    $keys = array("stuff" => "pizza", "name" => "Ethan");
    echo $stuff["name"], "\n"; // "Ethan"

    // print_r() shows PHP data 
    
    // Goes through array and prints key => value
    print_r($keys);

    // Goes through array and prints all indexes and elements
    print_r($stuff);

    /* Var_dump does everything print_r does but indicates TYPE other info
     You can also print out False (unlike print_r) */
    var_dump($keys);

    // BINDING AN ARRAY
    $binded = array();
    $va[] = "Hello"; // index 0 
    $va[] = "World"; // index 1
    print_r($va)

    $more = array();
    $va["x"] = 2;
    $va["y"] = 3;
    // Looping through key value array
    $more = array("age" => 16, "grade" => "junior");
    foreach($more as $k => $v){ //for each stuff where key maps to value
        echo "Key=", $k," Value=", $v, "\n";
    }

    //Looping through a linear array
    $stuff = array("Index0", "Index1");
    for($i = 0; $i < count($stuff); $i++){ 
        // count(array) tells you how many things there are in an array
        echo "I=", $i, " Val=", $stuff[$i], "\n";
    }

    // Nested arrays:
    $nested1 = array(array("Hello", "World"), array(1, 2));
    $nested1[1][1];

    $nested2 = array(
        'supples' => array(
            'pencils' => "Electronic",
            'pens' => "Ball point",
            'food' => "McDonalds"
        ),
        'ensembles' => array(
            'orchestra' => "violin",
            'band' => "trumpet",
            'jazz' => "saxophone"
        )
    );
    $nested2['ensembles']['jazz']; // grabbing key
?>