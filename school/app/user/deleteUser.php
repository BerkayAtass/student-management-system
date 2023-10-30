<?php

include "../../conn.php";
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    $em = "Warning";
    header("Location: ../../usersList.php?error=$em");
    exit;
}

if(isset($_GET['id'])){

    try {
        $id = $_GET['id'];
        $usersTable = "t_users";
        $classTable = "t_classes";
        $examsTable = "t_exams";
        $studentsTable = "t_classes_students";
        $lessonsTable = "t_lessons";

        $query = $conn->prepare("DELETE FROM $examsTable WHERE student_id = ?");
        $query->execute([$id]);

        $query = $conn->prepare("DELETE FROM $studentsTable WHERE student_id = ?");
        $query->execute([$id]);

        $query = $conn->prepare("DELETE FROM $classTable WHERE class_teacher_id = ?");
        $query->execute([$id]);
        
        $query = $conn->prepare("DELETE FROM $lessonsTable WHERE teacher_user_id = ?");
        $query->execute([$id]);
        
        $query = $conn->prepare("DELETE FROM $usersTable WHERE id = ?");
        $query->execute([$id]);

        header("Location: ../../usersList.php");
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