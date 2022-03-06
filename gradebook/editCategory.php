<!-- This program allows you to either update or delete a category -->


<?php
    /*
        Session data:
            $_SESSION['category_id'];
            $_SESSION['percent']; (Total percent of grade "unused")
            $_SESSION['name'];
            $_SESSION['gradePercent']; (The grade percent of category)
    */
    require "gradebookPDO.php";
    session_start();
    // if user types in link without logging in.
    if(!($_SESSION['Username'])){
        header("Location: Login.php");
        return;
    }
    if(isset($_GET['category_id']) && isset($_GET['percent'])){
        $_SESSION['category_id'] = $_GET['category_id'];
        $_SESSION['percent'] = $_GET['percent'];
        header("Location: editCategory.php");
        return;
    }
    
    $id = $_SESSION['category_id'];
    // No risk of user injection since data is coming from database
    $sql = "SELECT * FROM category WHERE category_id = $id";
    // Run straight query:
    $stmt = $pdo->query($sql);
    // Should only be 1 row since each category has unique category_id.
    $row = $stmt->fetch(PDO::FETCH_ASSOC);


    if(isset($_POST['return'])){
        header("Location: viewClass.php");
        // No need to unset category_id and percent data because it will automatically get reset if we re-enter page. 
        $name = $row['name'];
        return;
    }


   




    if(isset($_POST['gradePercent']) && isset($_POST['name'])){
        // If user didn't leave blank
        if(!("" == trim($_POST['name']))){
            // performs update operation to update category with the given category id
            $sql = "UPDATE category SET name = :name WHERE category_id = :category_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':name' => $_POST['name'],
                ':category_id' => $_SESSION['category_id']
            ));
            $_SESSION['success'] = "Category successfully updated";
            
            if("" == trim($_POST['gradePercent'])){
                header("Location: viewClass.php");
                return;
            }
        }
        // if user did not leave blank.
        if((!"" == trim($_POST['gradePercent']))){
            if($_POST['gradePercent'] > $_SESSION['percent']){
                $max = $_SESSION['percent'];
                $_SESSION['error'] = "ERROR: Modified percent greater than maximum: $max%";
                header("Location: editCategory.php");
                return;
            }
            $sql = "UPDATE category SET gradePercent = :gradePercent WHERE category_id = :category_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':gradePercent' => $_POST['gradePercent'],
                ':category_id' => $_SESSION['category_id']
            ));
            $_SESSION['success'] = "Category successfully updated";
            header("Location: viewClass.php");
            return;
        }


         
        
    }
   

    // If user selects delete button:
    if(isset($_POST['delete'])){
        $category_id = $_SESSION['category_id'];
        $sql = "DELETE from category WHERE category_id = $category_id";
        $stmt = $pdo->query($sql);
        header("Location: viewClass.php");
        $_SESSION['success'] = "$name deleted";
        return;
    }

    // prints any errors generated on page:\
    if(isset($_SESSION['error'])){
        echo '<p style = "color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }

?>
<html>
    <b><font size = 5> Editing "<?= $row['name'] ?>" in <?= $_SESSION['Sclass_name'] ?> </font></b>

    <form method = "post">
        <p>Edit category name: <input type = "text" name = "name"></p>
        <p>Edit category grade percent: <input type = "text" name = "gradePercent"></p>
        <input type = "submit">
        <input type = "submit" name = "return" value = "Exit">
    </form>

    <form method = "post">
        <p> <font size = 4 ><b> Delete category "<?=$row['name']?>":  </font></b> <input type = "submit" name = "delete" value = "DELETE"></p> 
    </form>
</html>