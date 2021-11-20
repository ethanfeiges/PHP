<?php
    $pdo = new PDO('mysql:host=localhost;dbname=users;charset=utf8mb4', "root","");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    return $pdo;
?>