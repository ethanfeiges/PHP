<!-- This is the central page that the user will see once they log in -->
<?php
    session_start();
    if(isset($_SESSION["Username"])){ // central.php looks for Login "Username" session
        echo "Welcome, ".$_SESSION["Username"]; 
    }
    // if user types in link without logging in
    else{
        header("Location: Login.php");
        return;
    }
?> 
    <p><a href = "Logout.php"> Logout</a></p>
    <p><a href = "classes.php"> View classes </a></p>
    

