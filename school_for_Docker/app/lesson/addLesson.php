<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role']) && $_SESSION['role'] === "admin"){
    if (isset($_POST['lesson_name']) && isset($_POST['teacher_id'])) {

        include "../../conn.php";
       
        $lesson_name = $_POST['lesson_name'];
        $teacher_id = $_POST['teacher_id'];

       
        if (empty($lesson_name)) {
            $em  = "Lesson name is required";
            header("Location: ../../addLessonIndex.php?error=$em");
            exit;
        } else if (empty($teacher_id)) {
            $em  = "Teacher is required";
            header("Location: ../../addLessonIndex.php?error=$em");
            exit;
        }else {
    
            
                $school = "t_lessons";
                $query = $conn->prepare("INSERT INTO $school(teacher_user_id, lesson_name) VALUES (?, ?)");
                $query->execute(array(
                    $teacher_id,
                    $lesson_name,

                ));

                $em  = "Success";
                header("Location: ../../lessonsList.php?error=$em");
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