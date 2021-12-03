<?php
   require_once "pdo.php";
   session_start(); 
?>
<!--This page displays all of the users in an HTML table -->
<html><head></head>
<body>
    <table>
    <?php
        
        // Any "error message" in this application gets stored in $_SESSION['error']
        if(isset($_SESSION['error'])){
            echo '<p style = "color:red">'.$_SESSION['error']."</p>\n";
            unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
            // FLASH MESSAGE: Session message that gets deleted after it's saved
            echo '<p style = "color:green">'.$_SESSION['success']."</p>\n";
            unset($_SESSION['success']);
        }
        echo('<table border="1">'."\n");
        // No user input, so there will be no risk of user injection -> We can use a query. 
        $stmt = $pdo->query("SELECT name, email, password, user_id FROM users");
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            echo "<tr><td>";
            echo(htmlentities($row["name"]));
            echo "</td><td>";
            echo(htmlentities($row["email"]));
            echo "</td><td>";
            echo(htmlentities($row["password"]));
            echo "</td><td>";
            //passing in info THROUGH A QUEERY from row we're working with (GET PARAMETER)
            echo('<a href = "edit.php?user_id='.$row['user_id'].'">Edit</a> /');
            echo('<a href = "delete.php?user_id='.$row['user_id'].'">Delete</a>');
            echo("\n</form>\n");
            echo("</td></tn>\n");
        }
    ?>
    </table>
    <a href = "add.php" > Add New </a>
</body>