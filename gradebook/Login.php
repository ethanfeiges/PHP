<!--
    This code allows the user to either create a new account of log into an already existing one
    PHP and an SQL database containing "users" are implemented
-->

<?php
    session_start();
    // if user types in link without logging in.
   
    require "gradebookPDO.php"; // imports pdo connection
    if(isset($_POST["Username"]) && $_POST["Password"]){
        
        // checks database for row with username and password
        $sql2 = "SELECT * FROM student WHERE username = :username AND password = :password";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute(array(":username" => $_POST["Username"], ":password" => $_POST["Password"]));
        
        if(isset($_POST["create"])){
            
            // Checks that there is not already an account of the same username & password
            if($stmt2->rowCount() == 0){
                $sql = "INSERT INTO student(username, password) VALUES (:username, :password)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':username' => $_POST["Username"],
                    ':password' => $_POST["Password"]
                ));
                $_SESSION["Username"] = $_POST["Username"];
                $_SESSION["Password"] = $_POST["Password"];
                header("Location: central.php");
                return;
            }
            else{ // such an account already exists
                $_SESSION["error"] = "User already exists";
            }
           
        }
        else{ // user pressed "login"
            unset($_SESSION['account']); // remove previously-stored data
            if($stmt2->rowCount() > 0){ // If SQL entity exists in stdudent database
                $_SESSION["Username"] = $_POST["Username"];
                $_SESSION["Password"] = $_POST["Password"];
                header("Location: central.php");
                return;
            }
            else { // $stmt2->rowCount() == 0 (No such account stored in student database)
                $_SESSION["error"] = "Wrong login";
                header('Location: Login.php');
                return;
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
</html>

<?php
    // Flash message: if user fails to login
    if(isset($_SESSION['error'])){
        echo '<p style = "color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }
   
?>