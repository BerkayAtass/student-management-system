<?php

include "../../conn.php";
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    $em = "Warning";
    header("Location: ../../classList.php?error=$em");
    exit;
}

if(isset($_GET['id'])){

    try {
        $id = $_GET['id'];
        $classTable = "t_classes";
        $examsTable = "t_exams";
        $studentsTable = "t_classes_students";



        $query = $conn->prepare("DELETE FROM $examsTable WHERE class_id = ?");
        $query->execute([$id]);

        $query = $conn->prepare("DELETE FROM $studentsTable WHERE class_id = ?");
        $query->execute([$id]);
        
        $query = $conn->prepare("DELETE FROM $classTable WHERE id = ?");
        $query->execute([$id]);

        header("Location: ../../classList.php");
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