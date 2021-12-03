<?php
    require_once "pdo.php";
    session_start();
    // if post data is sent from the form
    if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])){
        
        // Check that the user entered in text for user and password
        if(strlen($_POST['name']) < 1 || strlen($_POST['password']) < 1){
            $_SESSION['error'] = "Missing data";
            header("Location: add.php");
            return;
        };

        //check that the email has an "@" in it
        if(strpos($_POST['email'], '@') == false){
            $_SESSION['error'] = "Bad data";
            header("Location: add.php");
            return;
        }
        

        // adding user to database 
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ":name" => $_POST['name'],
            ":email" => $_POST['email'],
            ":password" => $_POST['password']
        ));
        $_SESSION['success'] = 'Record Added';
        
        // goes to index.php (hompage) after the client has successfully created a user 
        header('Location: index.php');
        return;
    }
    
    // Prints session data if any errors have occured
    if(isset($_SESSION['error'])){
        echo '<p style = "color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }

?>



<html>
    <p>Add a New User </p>
    <form method = "post">
        <p> Name <input type = 'text' name = "name"></p>
        <p> Email <input type = 'text' name = "email"></p>
        <p> Password <input type = 'password' name = 'password'></p>
        <input type = "submit" value = "Add New">
        <a href = 'index.php'>Cancel</a></p>

    </form>
</html>