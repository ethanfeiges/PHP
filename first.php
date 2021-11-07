<html>
    <!--Static HTML part-->
    <h1>Hello!</h1>
    <p>
    <!--Server runs php code as it produces request/response cycle-->
    <!--Website sees the output of the code-->
    <?php
        // You can do more with double-quoted strings compared to single-quoted strings
        echo "Hi there.\n";


        //Single quote strings also have embedded newlines but do not expand with \n or dollar sign ($) //
        
        echo "Php has embedded new lines in 
        strings so this gets shown in the website
        like
        this";


        //Variables: need dollar sign-->
        $name = "Ethan";
        $age = 12;

        //Echo can be trated like a function with mutliple parameters indicated by the absence of a pair of parthenthesis //
        echo "How are you doing $name?";

        echo "This" , "concatinates";
        //Output: How are you doing Ethan?-->
        
        // Print statement is a function with ONLY one parameter-->
        print ("One");
        print("String");
        
    ?>
    </p>
    <p>More static text</p>
    
</html>