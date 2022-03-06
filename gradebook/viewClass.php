<!--This page will allow the user to view their current grade in their class and will display all assignment categories-->

<!-- The user will be able to add new assignment categories and click already-established categories for details -->

<?php
    session_start();
    require "gradebookPDO.php";
    
    // Store GET url query in session data:
    // This session data would automatially get reset for any class the user clicks on
    if(isset($_GET['class_name']) && isset($_GET['class_id'])){
        // stores data in sessions and then redirects to prevent user manipulation
        $_SESSION['Sclass_name'] = $_GET['class_name'];
        $_SESSION['Sclass_id'] = $_GET['class_id'];
        header("Location: viewClass.php");
        return;
    }


    // Variables used below
    $class = $_SESSION['Sclass_id'];
    $class_name = $_SESSION['Sclass_name'];



    if(isset($_SESSION['error'])){
        echo '<p style = "color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }
?>



<table border = 1>
    <p><font size = 5> Current class categories for <?= $class_name ?>: </font></p>
    <td>Category</td>
    <td>Percent of grade</td>
    <?php
        
        /* variable keeps track of the categories and its percentages
            (Ensures that all category percentages sum up to a maximum of 100)
        */
        $percentRemaining = 100;
    

        /* Variable keeps track of categories that have assignments submitted 
            (Used for final grade calculation)

            Example, if $totalPercent = 100 after we check each category, all categories have at least ONE assignment in them. 
        */
        $totalPercent = 100;



        // Variable keeps track of total grade;
        $totalGrade = 0;
        
        // Since all data is confirmed to be from database, there is no risk of user injection. 
        // class_id is a foreign key that relates categories to classes. 
        $sql = "SELECT * FROM category WHERE class_id = $class";
        $stmt = $pdo->query($sql);
        


        $stmt->setFetchMode(PDO:: FETCH_ASSOC);
        $rows = $stmt->fetchAll();
        // get final percent remaining after each row
        foreach ($rows as $r){
            $percentRemaining -= $r['gradePercent'];
            

            // check all assignments for each category
            $category_id = $r['category_id'];
            $sql = "SELECT * FROM assignment WHERE category_id = $category_id";
            $stmt = $pdo->query($sql);
            
            // if no current assignments
            if($stmt->rowCount() == 0){
                /* Denominator decreases in weighted calculation -> (other categories are weighted more) */
                $totalPercent -= $r['gradePercent'];
            }
        }
        // if category percentages add up to less than 100 -> weight categories more
        $totalPercent -= $percentRemaining;
        
        
        // boolean to see if ANY assignment has been added
        $added = false;


        // done in a separate foreach loop so we can pass in $percentRemaining for edit href and calculate weight of each category
        foreach ($rows as $r){
            echo"<tr><td>";
            echo(htmlentities($r["name"]));
            echo'</td><td>';
            echo(htmlentities($r["gradePercent"])."%");

            // calculates grade for each category point:
            // resets variables for each category:
            $points = 0;
            $possible = 0;
            $category_id = $r['category_id'];
            $sql = "SELECT * FROM assignment WHERE category_id = $category_id";
            $stmt = $pdo->query($sql);
            
            // add up points and possible points for each assignment
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $points += $row['points'];
                $possible += $row['possiblePoints'];
            }
            
            
            // If an assignment WITH points has been submitted into this category
            if($possible != 0){
                $added = true;
                $totalGrade += ($r['gradePercent'] / $totalPercent) * ($points / $possible); 
            }
            
           
            
            echo"</td><td>";
            // passes in category_id of each specific row as a URL query
            echo('<a href = "editCategory.php?category_id='.$r['category_id'].'&percent='.$percentRemaining.'">Edit/</a> <a href = "assignments.php?category_id='.$r['category_id'].'&name='.$r['name'].'">Expand</a>');
            echo "</td></tr>\n";
        }
        
    ?>
</table>

<?php
// Displays grade in class:
    if($added){
        $grade = "A";
        if($totalGrade < .60){
            $grade = "F";
        }
        else if($totalGrade < .70){
            $grade = "D";
        }
        else if($totalGrade < .80){
            $grade = "C";
        }
        else if($totalGrade < .9){
            $grade = "B";
        }
        echo("<font size = 5>GRADE: $grade: ".round(($totalGrade * 100) , 2)."%   </font>");
    }
    else{
        echo("<font size = 5> GRADE: N/A </font>");
    }   
?>

<?php
     // if user submits data (sends a post query):
     if(isset($_POST['category_name']) && isset($_POST['gradePercent'])){
        $_SESSION['category_name'] = $_POST['category_name'];
        $_SESSION['gradePercent'] = $_POST['gradePercent'];
        header("Location: viewClass.php");
        return;
         
    }

    if(isset($_SESSION['category_name']) && isset($_SESSION['gradePercent'])){
        // stops the user from entering a number greater than the greatest possible percentage (all category percentages need to add up to 100%)
        if($percentRemaining < $_SESSION['gradePercent']){
            $_SESSION['error'] = "Invalid grade percentage: (This category can only be a maximum of $percentRemaining%)";
        }
        else{
            // add category into database with user data + foreign key
            $sql = "INSERT INTO category (name, gradePercent, class_id) VALUES (:name, :gradePercent, :class_id)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ":name"=>$_SESSION['category_name'],
                ":gradePercent"=>$_SESSION['gradePercent'],
                ":class_id"=>$_SESSION['Sclass_id']
            ));
        }
        
        // unset session data for the next time user moves to this page
        unset($_SESSION['category_name']);
        unset($_SESSION['gradePercent']);
        header("Location: viewClass.php");
        return;
    }


?>


<html>
    <br></br>
    <b><font size = 5>Add new grading category </font></b>
    <form method = "post">
        <p> <font size = 4>Category name:</font>
        <input type = "text" name = "category_name" size = "20"></p>
        <p> <font size = 4> Percent of grade:</font>
        <input type = "text" name = "gradePercent" size = "1">%</p>
        <input type = "submit" value = "Add">
    </p>
    <?php
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

<p><a href = "classes.php">Return to class list</a></p>
</html>