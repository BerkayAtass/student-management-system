<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role']) && $_SESSION['role'] === "admin"){
    if (isset($_POST['class_id']) && isset($_POST['student_id'])) {

        include "../../conn.php";
       
        $class_id = $_POST['class_id'];
        $student_id = $_POST['student_id'];

       
        if (empty($class_id)) {
            $em  = "Class name is required";
            header("Location: ../../addStudentIndex.php?error=$em");
            exit;
        } else if (empty($student_id)) {
            $em  = "Student is required";
            header("Location: ../../addStudentIndex.php?error=$em");
            exit;
        }else {
    
            
                $school = "t_classes_students";
                $query = $conn->prepare("INSERT INTO $school(class_id, student_id) VALUES (?, ?)");
                $query->execute(array(
                    $class_id,
                    $student_id,

                ));

                $em  = "Success";
                header("Location: ../../studentsList.php?error=$em");
                exit;
            
            
        }
    } else {
        header("Location: ../../addStudentIndex.php");
        exit;
    }
}else{
    header("Location: ../../addStudentIndex.php");
        exit;
}
?>