<!-- This program allows you to either edit a class or delete it entirely -->

<?php
    require "gradebookPDO.php"; // imports pdo connection
    session_start();
    // if user types in link without logging in.
    if(!($_SESSION['Username'])){
        header("Location: Login.php");
        return;
    }
    // Runs an SQL statement checking if there is a row with the class_id passed in through get request
    $sql = "SELECT * FROM class WHERE class_id = :class_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ":class_id" => $_GET['class_id']
    ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);


    // if user changes the Get URL query or deletes it entirely
    if($row == false || !isset($_GET['class_id'])){
        $_SESSION['error'] = "Manipulated class_id";
        unset($_SESSION['class_name']);
        header("Location: classes.php");
        return;
    }

    $student = $row['student_id'];
    $class = $row['class_id'];
   
   // if user presses delete button
    if(isset($_POST['delete'])){
        
        // removing class specifically for this user:
        $sql = "DELETE from class WHERE class_id = $class AND student_id = $student";
        // Since there is no user input involved, we can do a direct query.
        $stmt = $pdo->query($sql);
        $_SESSION['success'] = 'Class successfully deleted';
        unset($_SESSION['class_name']);
        header("Location: classes.php");
        return;
   }

   // if user edits class
   if(isset($_POST['EDIT']) && isset($_POST['name'])){
       $sql = "UPDATE class SET name = :name WHERE student_id = :student AND class_id = :class";
       $stmt = $pdo->prepare($sql);
       $stmt->execute(array(
            ':class' => $class,
            ':student' => $student,
            ':name' => $_POST['name']
       ));
       $_SESSION['success'] = "Class successfully updated";
        unset($_SESSION['class_name']);
        header("Location: classes.php");
        return;
   }

   // if user presses cancel button
   if(isset($_POST['cancel'])){
        unset($_SESSION['class_name']);
        header("Location: classes.php");
        return;
   }

?>
<html>
   <p><b> <font size = "5"> DELETE CLASS: </font></b></p>
    <form method = "post">
    <p style = "margin-left: 40px"><font size = "4">•Would you like to delete <?= htmlentities($row['name']) ?>?</font></p>
    <p style = "margin-left: 40px"> <input type = "submit" name = "delete" value = "DELETE"><input type = "submit" name = "cancel" value = "EXIT"></p>
    

    </form>
    
   
    <p><b><font size = "5">UPDATE CLASS:</font></b></p>
    <form method = "post">
        
       <p style = "margin-left: 40px"> <font size = "4"> Change class name: </font><input type = "text" name = "name" size = "20"></p>

       <p style = "margin-left: 40px"><input type = "submit" name = "EDIT" value = "Submit"></p>
    </form>



</html>
