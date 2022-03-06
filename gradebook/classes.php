<!-- Programs displays all of the current classes a student is enrolled in and allows user to insert more classes -->


<?php
   require "gradebookPDO.php"; // imports pdo connection
   session_start();

   // if user types in link without logging in.
    if(!($_SESSION['Username'])){
        header("Location: Login.php");
        return;
    }
    

   // student_id is a foreign key that relates classes to a student
   $sql = "SELECT student_id FROM student WHERE username = :Username AND password = :Password";
   $stmt = $pdo->prepare($sql);
   $stmt->execute(array(
       ':Username' => $_SESSION["Username"],
       ':Password' => $_SESSION["Password"]
   ));
   $row = $stmt->fetch(PDO::FETCH_OBJ);
   $_SESSION["student_id"] = $row->student_id;
   

   // create session. Session data prevents user from submitting twice
   if (isset ($_POST['class_name'])){
        $_SESSION['class_name'] = $_POST['class_name'];
        header("LOCATION: classes.php");
        return;
    }

    // create class using session ID:
    if(isset($_SESSION['class_name'])){
        $sql = "INSERT INTO class (name, student_id) VALUES (:name, :student_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':name' => $_SESSION['class_name'],
            ':student_id' => $_SESSION['student_id']
        ));
        unset($_SESSION['class_name']);
    }

    // set for viewClasses 
    $_SESSION['percentRemaining'] = 100;
   
?>
<html><font size = 7><b> Enrolled classes:</b></font>
<br></br>

<table border = '1'>
<?php
    $x  = $_SESSION['student_id'];
    $sql = "SELECT name, class_id FROM class WHERE student_id = $x";
    $stmt = $pdo->query($sql);
    $num = $stmt->rowCount();
    echo("<font size = 4><b>You are currently enrolled in $num classes:</b></font>");
    // displays all currently enrolled classes in table form.
    // Also provides links to edit or view classes
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo"<tr><td>";
        echo(htmlentities($row["name"]));
        echo"</td><td>";
        echo('<a href = "editClass.php?class_id='.$row['class_id'].'">Edit</a> /');
        /* Get URL query passes in specific class_id and class_name data for each row */
        echo('<a href = "viewClass.php?class_id='.$row['class_id'].'&class_name='.$row['name'].'">View</a>');
        echo "</td></tr>\n";
    }
     // print flash messages:
     if(isset($_SESSION['error'])){
        echo '<p style = "color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }
    if(isset($_SESSION['success'])){
        // FLASH MESSAGE: Session message that gets deleted after it's saved
        echo '<p style = "color:green">'.$_SESSION['success']."</p>\n";
        unset($_SESSION['success']);
    }
?>
</table>

<br></br>
<b><font size = 5>Enroll in a new class </font></b>
<form method = "post">
<p> <font size = 4>Name: </font>
    <input type = "text" name = "class_name" size = "40"></p>
    <input type = "submit" value = "Submit">
    <a href = "central.php"> Return to Homepage </a>
</p>





</html>