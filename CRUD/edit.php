<!--This page allows the user to edit their acccount -->




<?php
require_once "pdo.php";
session_start();

// updates database
if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['user_id'])){
    $sql = "UPDATE users SET name = :name, email = :email, password = :password WHERE user_id = :xyz";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':name' => $_POST['name'],
        ':email' => $_POST['email'],
        ':password' => $_POST['password'],
        ':xyz' => $_POST['user_id']
    ));
    $_SESSION['success'] = "Record updated";
    header('Location: index.php');
    return;
}

// $_GET data is always sent BEFORE $_POST data (this all gets checked first)
// Both edit and delete have a problem to check the ID
$stmt = $pdo->prepare("SELECT * FROM users where user_id = :urlget");
$stmt->execute(array(":urlget" => $_GET['user_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row == false){
    $_SESSION['error'] = 'Bad value for user_id';
    header("Location: index.php");
    return;
}   

?>
<!--Default values are there so the user doesn't need to type them in -->
<html>
    <form method = "post">
    <p> Edit User </p>
    <p>Name <input type = "text" name = "name" value = "<?= htmlentities($row['name'])
    ?>"></p>
    <p>Email <input type = "text" name = "email" value = "<?= htmlentities($row['email'])
    ?>"></p>
    <p>Password<input type = "text" name = "password" value = "<?= htmlentities($row['password']) ?>" ></p>
    <input type = 'hidden' name = "user_id" value = "<?= $row['user_id'] ?>">
    <input type = "submit" value = "Update">
    <a href = "index.php"> Cancel </a>
    </form>
</html>
