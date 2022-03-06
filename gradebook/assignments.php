<!--This page allows the user to view and insert assignments to update their grade -->

<?php
    require("gradebookPDO.php");
    session_start();
    // if user types in link without logging in.
    if(!($_SESSION['Username'])){
        header("Location: Login.php");
        return;
    }
    if(isset($_GET['category_id']) && isset($_GET['name'])){
        $_SESSION['category_id'] = $_GET['category_id'];
        $_SESSION['category_name'] = $_GET['name'];
        header("Location: assignments.php");
        return;
    }
    // variable allows us to use in html
    $name = $_SESSION['category_name'];
    $category_id = $_SESSION['category_id'];
    

    // create session data to avoid resubmission 
    if(isset($_POST['assignment_name']) && isset($_POST['points']) && isset($_POST['possible'])){
        $_SESSION['assignment_name'] = $_POST['assignment_name'];
        $_SESSION['points'] = $_POST['points'];
        $_SESSION['possible'] = $_POST['possible'];
        header("Location: assignments.php");
        return;
    }

    // Insert data into assignment SQL database with category_id foreign key
    // category_id associates each assignment with a category.
    if(isset($_SESSION['assignment_name']) && isset($_SESSION['points']) && isset($_SESSION['possible'])){
        $sql = "INSERT INTO assignment (name, points, possiblePoints, category_id) VALUES (:name, :points, :possible, :category_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ":name" => $_SESSION['assignment_name'],
            ":points" => $_SESSION['points'],
            ":possible" => $_SESSION['possible'],
            ":category_id"=>$category_id
        ));

        // unset session data to avoid submission when user returns to page.
        unset($_SESSION['assignment_name']);
        unset($_SESSION['points']);
        unset($_SESSION['possible']);
    }

    // perform delete operation
    if(isset($_POST['delete']) && isset($_POST['assignment_id'])){
        $assignment_id = $_POST['assignment_id'];
        $sql = "DELETE FROM assignment WHERE assignment_id = $assignment_id";
        $stmt = $pdo->query($sql);
    }




   

?>

<table border = 2>
    <tr><td>Assignment</td>
    <td> Points </td></tr>

    <p> <font size = 5> Current assignments under <?= $name?> </font>
    <?php 
     $sql = "SELECT * FROM assignment WHERE category_id = $category_id";
     $stmt1 = $pdo->query($sql);
    while($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
        echo"<tr><td>";
        echo(htmlentities($row["name"]));
        echo"</td><td>";
        echo(htmlentities($row['points']). "/" .$row['possiblePoints']);
        echo"</td><td>";
        // Gives user option to click href or delete on the spot
        // Passes row's assignment_id as a hidden post to enable deletion
        echo('<form method = "post"> <a href = "editAssignment.php?assignment_id='.$row['assignment_id'].'"> Edit </a> / <input type = "submit" name = "delete" value = "delete"> <input type = "hidden" name = "assignment_id" value = "'.$row['assignment_id'].'"></form></p>');
        echo "</td></tr>\n";
    }
    ?>
    </p>

</table>

<html>
    <br></br>
    <b><font size = 5> Create a new assignment</font></b>
    <form method = "post">
        <p>Assignment Name: <input type = "text" name = "assignment_name" size = "20"></p>
        <p>Score: <input type = "text" name = "points" size = "1"> / <input type = "text" name = "possible" size = "1"></p>
        <input type = "submit" value = "Submit">
        <a href = "viewClass.php"> Return to <?= /*(passed from viewClass.php)*/$_SESSION['Sclass_name'] ?></a>
    </form>
</html>

<?php
    // flash message
     if(isset($_SESSION['error'])){
        echo '<p style = "color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }
?>