<!--
    This code allows the user to either create a new account of log into an already existing one
    PHP and an SQL database are implemented
-->

<?php
    $message = null;
    require "pdoUsers.php"; // imports pdo connection
    if(isset($_POST["Username"]) && $_POST["Password"]){
        $sql2 = "SELECT * FROM members WHERE username = :username AND password = :password";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute(array(":username" => $_POST["Username"], ":password" => $_POST["Password"]));
        
        if(isset($_POST["create"])){
            
            // Checks that there is not already an account made with same username/password
            if($stmt2->rowCount() == 0){
                $sql = "INSERT INTO members(username, password) VALUES (:username, :password)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':username' => $_POST["Username"],
                    ':password' => $_POST["Password"]
                ));
            }
            else{ // already an account
                $message = "User already exists";
            }
           
        }
        else{ // user pressed "login"
            if($stmt2->rowCount() > 0){ // SQL entity exists
                $message = "Welcome";
            }
            else { // $stmt2->rowCount() == 0
                $message = "Wrong login";
            }
        }
        
    }
   


?>
<html>
    <font = 5><b> Please enter Username and Password:</b></font>
    <form method = "post">
        <p>Username:</p><input type = "text" name = "Username">
        <p>Password:</p><input type = "text" name = "Password">
        <p></p>
        <input type = "submit" name = "create" value = "Create Account">

        <input type = "submit" name = "login" value = "Login">
    </form>
    <p> <?php if (!is_null($message)){
        echo $message;
        }?>
    </p>
</html>