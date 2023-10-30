<?php

include "../../conn.php";
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['role']) || !($_SESSION['role'] === "admin" || $_SESSION['role'] === "teacher") ) {
    $em = "Warning";
    header("Location: ../../examsList.php?error=$em");
    exit;
}

if(isset($_GET['id'])){

    try {
        $id = $_GET['id'];
        $examTable = "t_exams";

        
        $query = $conn->prepare("DELETE FROM $examTable WHERE id = ?");
        $query->execute([$id]);

        header("Location: ../../examsList.php");
        exit;
    } catch (PDOException $e) {
        
        $error_message = "Error deleting user: " . $e->getMessage();
        echo $error_message;
    }
    
} else {
    echo "POST data is missing.";
    print_r($_POST);
}

?>