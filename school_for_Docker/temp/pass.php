<?php
    $pass = "aa";
    $pass = password_hash($pass, PASSWORD_ARGON2ID);
    echo $pass;
?>