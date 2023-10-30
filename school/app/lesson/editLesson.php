<?php
session_start();
include "../../conn.php";

if (isset($_SESSION['id']) && isset($_SESSION['role']) && ($_SESSION['role'] === "admin" || $_SESSION['role'] === "teacher")) {
    if (isset($_POST['id'], $_POST['lesson_name'], $_POST['teacher_id'])) {
        $id = $_POST['id'];
        $lesson_name = $_POST['lesson_name'];
        $teacher_id = $_POST['teacher_id'];
      

        if (empty($lesson_name)) {
            $em = "Lesson name is required";
            header("Location: ../../editLessonIndex.php?id=$id&error=$em");
            exit;
        } elseif (empty($teacher_id)) {
            $em = "Teacher id is required";
            header("Location: ../../editLessonIndex.php?id=$id&error=$em");
            exit;
        } else {

            $query = $conn->prepare("UPDATE t_lessons SET teacher_user_id = ?, lesson_name = ?  WHERE id = ?");
            $query->execute([$teacher_id, $lesson_name, $id]);

            $em = "Success !!";
            header("Location: ../../lessonsList.php?id=$id&error=$em");
            exit;
        }
    } else {
        header("Location: ../../editLessonIndex.php");
        exit;
    }
} else {
    header("Location: ../../editLessonIndex.php");
    exit;
}
?>
