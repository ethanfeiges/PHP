<?php
    session_start();
    session_destroy(); // wiping out all username and password data.
    header("Location: Login.php");
    return;
?>