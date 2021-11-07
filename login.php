<?php



?>

<html>
    <p>Please log in</p>
    <form method = "POST">
        <p><label for="username">Username</label>
        <input type='text' name="username" size='40' id = "username"></p>
        <p><label for ="passwoord">Password</label>
        <input type = 'text' name = "password" size = '40' id = "password"></p>
        <input type="submit" value = "Log in"/>
        <input type="reset">
    </form>
    <?php
    if(!($_POST["username"])){
        echo("<p>Please complete username</p>");
    }
    if(!($_POST["password"])){
        echo("<p>Please complete password</p>");
    }
    ?>
</html>