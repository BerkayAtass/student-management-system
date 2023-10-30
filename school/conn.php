<?php

$sName = "localhost";
$uName = "root";
$pass = "";
$db_name = "school";

try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     $adminCheck = $conn->prepare("SELECT id FROM t_users WHERE username = 'admin'");
     $adminCheck->execute();
     $adminExists = $adminCheck->fetchColumn();
 
     if (!$adminExists) {
         $password = "admin";
         $hashedpassword = password_hash($password, PASSWORD_ARGON2ID);
         $sql = "INSERT INTO t_users (name, surname, username, password, role) 
         VALUES ('admin', 'admin', 'admin', '$hashedpassword', 'admin')";
         $conn->exec($sql);
         echo "Admin user created successfully.";
     }
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}
