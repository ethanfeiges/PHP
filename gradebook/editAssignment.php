<!--This allows you to edit a specific assignment -->
<?php
    require("gradebookPDO.php");
    session_start();
    // if user types in link without logging in.
    if(!($_SESSION['Username'])){
        header("Location: Login.php");
        return;
    }
    // GET URL query is always passed through when link is clicked on 
    if(isset($_GET['assignment_id'])){
        $_SESSION['assignment_id'] = $_GET['assignment_id'];
        header('Location: editAssignment.php');
        return;
    }
    $id = $_SESSION['assignment_id'];
    $sql = "SELECT * FROM assignment WHERE assignment_id = $id";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);


    if(isset($_POST['name']) && isset($_POST['points']) && isset($_POST['possible'])){
        $_SESSION['name'] = $_POST['name'];
        $_SESSION['points'] = $_POST['points'];
        $_SESSION['possible'] = $_POST['possible'];
        header("Location: editAssignment.php");
        return;
    }

    if(isset($_SESSION['name']) && isset($_SESSION['points']) && isset($_SESSION['possible'])){
        $sql = "UPDATE assignment SET name = :name, points = :points, possiblePoints = :possible WHERE assignment_id = :assignment_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ":name" => $_SESSION['name'],
            ":points" => $_SESSION['points'],
            ":possible"=> $_SESSION['possible'],
            ":assignment_id" => $_SESSION['assignment_id']
        ));
        header("Location: assignments.php");
        // to avoid immediately updating once user clicks again.
        unset($_SESSION['name']);
        unset($_SESSION['points']);
        unset($_SESSION['possible']);
        return;
    }
?>


<html>
    <p> <font size = 5> Editing: <?= $row['name'] ?> </font></p>

    <form method = "post">
        <p>Name: <input type = "text" size = 20 value = <?= $row['name'] ?> name = "name"> </p>
        <p>Score: <input type = "text" size = 1 name = "points" value = <?= $row['points']?>>/ <input type = "text" size = 1 value = <?=$row['possiblePoints'] ?> name = "possible"></p>

        <input type = "submit" value = "submit">
    </form>

    <a href = "assignments.php"> Return to assignments </a> 
</html>