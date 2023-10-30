<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role']) && $_SESSION['role'] === "admin"){
    if (isset($_POST['class_name']) && isset($_POST['teacher_id'])) {

        include "../../conn.php";
       
        $class_name = $_POST['class_name'];
        $teacher_id = $_POST['teacher_id'];

       
        if (empty($class_name)) {
            $em  = "Class name is required";
            header("Location: ../../addClassIndex.php?error=$em");
            exit;
        } else if (empty($teacher_id)) {
            $em  = "Teacher is required";
            header("Location: ../../addClassIndex.php?error=$em");
            exit;
        }else {
    
            
                $school = "t_classes";
                $query = $conn->prepare("INSERT INTO $school(class_name, class_teacher_id) VALUES (?, ?)");
                $query->execute(array(
                    $class_name,
                    $teacher_id,

                ));

                $em  = "Success";
                header("Location: ../../classList.php?error=$em");
                exit;
            
            
        }
    } else {
        header("Location: ../../addLessonIndex.php");
        exit;
    }
}else{
    header("Location: ../../addLessonIndex.php");
        exit;
}
?>