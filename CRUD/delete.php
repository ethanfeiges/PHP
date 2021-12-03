<!--This page allows for the user to delete an account -->

<?php
    require ("pdo.php");
    session_start();
   

    //Checks if there is a row with the user_id sent through the get request
    // (Ensures that the user did not manipulate the get request)
    $stmt = $pdo->prepare("SELECT name, user_id FROM users WHERE user_id = :x");
    $stmt->execute(array(
        ":x" => $_GET['user_id']
    ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    
    if($row == false){ // if cannot find row with user_id = $_GET['user_id']
        $_SESSION['error'] = 'Bad value for user_id';
        header("Location: index.php");
        return;
    }

    // generates session data if the user_id get request was deleted altogether
    if(!isset($_GET['user_id']) ){
        $_SESSION['error'] = "Missing user_id";
        header("Location: delete.php");
        return;
    }


    // Performs delete operation.
    if(isset($_POST['delete']) && isset($_POST['user_id'])){
        $sql = "DELETE FROM users WHERE user_id = :x";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ":x" => $_POST['user_id']
        ));
        $_SESSION['success'] = "Record deleted";
        header('Location: index.php');
        return;
    }
    
    
    // prints out any session error
    if(isset($_SESSION['error'])){
        echo '<p style = "color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }
?>
<html>
    <!--htmlentities is needed because 'name' originally came from client -->
    <!--NOTE: only call htmlentities when RETRIEVING data, NOT INSERTING IT -->
    
    <p>Confirm: Deleting <?= htmlentities($row['name']) ?></p>
    <form method = "post">
        
        <!--Sends $row['user-id'] when client presses submit button -->
        <input type = "hidden" name = "user_id" value = "<?= $row['user_id'] ?>">
        <input type = "submit" value = "Delete" name = 'delete'>
        <a href = 'index.php'>Cancel </a>
    </form>

</html>