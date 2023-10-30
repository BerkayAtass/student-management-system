<?php
session_start();
include "../../conn.php";

if (isset($_SESSION['id']) && isset($_SESSION['role']) && ($_SESSION['role'] === "admin" || $_SESSION['role'] === "teacher")) {
    if (isset($_POST['id'], $_POST['class_name'], $_POST['teacher_id'])) {
        $id = $_POST['id'];
        $class_name = $_POST['class_name'];
        $teacher_id = $_POST['teacher_id'];

        if ($_SESSION['role'] === "teacher") {
            // If the user is a teacher, can only edit her own class
            $teacher_id_session = $_SESSION['id'];
            $query = $conn->prepare("SELECT class_teacher_id FROM t_classes WHERE id = ?");
            $query->execute([$id]);
            $class_teacher_id = $query->fetchColumn();
            
            if ($class_teacher_id !== $teacher_id_session) {
                $em = "You can only edit your own class.";
                header("Location: ../../editClassIndex.php?id=$id&error=$em");
                exit;
            }
        }

        if (empty($class_name)) {
            $em = "Class name is required";
            header("Location: ../../editClassIndex.php?id=$id&error=$em");
            exit;
        } elseif (empty($teacher_id)) {
            $em = "Teacher id is required";
            header("Location: ../../editClassIndex.php?id=$id&error=$em");
            exit;
        } else {
            $query = $conn->prepare("UPDATE t_classes SET class_teacher_id = ?,class_name = ?  WHERE id = ?");
            $query->execute([$teacher_id, $class_name, $id]);

            $em = "Success !!";
            header("Location: ../../classList.php?id=$id&error=$em");
            exit;
        }
    } else {
        header("Location: ../../editClassIndex.php");
        exit;
    }
} else {
    header("Location: ../../editClassIndex.php");
    exit;
}

?>
