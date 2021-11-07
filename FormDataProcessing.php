<html>
    <p>Guessing game</p>
<form method="checkbox">
   <p>Guess the number<br/>
    <input type="checkbox" name = "guess" value = "100" >
        100 <br>
    <input type="checkbox" name = "guess" value = "59" >
        59 <br>
    <input type = "checkbox" name = "guess" value = "2">
        2 <br>
    
</form>
<!--You can assign a php variable to a value (comes from user input). 
            Ex: value = "< ? php   $aPhpVar   ? >" -->
<!-- However, this makes you suspectible to HTML injection: where a user types HTML in the prompt which can take over the page -->
<form method = "post">
    <p><label for="guess">MyText</label>
    
    <!--htmlentities: takes data and converts anything that can be an html entity and prints it out as an html entity: PREVENTS HTML INJECTION -->
    <!--$oldguess retains value to send as post request -->
    <input type ="text" name="information" size="40" value="<? htmlentities($oldguess) ?>"/></p>
    <!--Sends post to new req/res cycle -->
    <input type="submit"/>
</form>
</p>
    <?php
    /*isset checks if post:
        Assigns either value of key guess or an empty string
        */
        $oldguess = isset($_POST['guess']) ? $_POST['guess']: '';


        print_r($_GET); // Prints out all $_GET key/values (Come after ?(Query paramter))
        print_r($_POST); // Prints out all $_POST key/values. (It is sent as part of the connection)

    ?>
</html>