<?php
session_start();
include "../../conn.php";

if (isset($_SESSION['id']) && isset($_SESSION['role']) && $_SESSION['role'] === "admin") {
    if (isset($_POST['id'], $_POST['class_id'])) {
        $id = $_POST['id'];
        $class_id = $_POST['class_id'];
      

        if (empty($class_id)) {
            $em = "Class name is required";
            header("Location: ../../editStudentIndex.php?id=$id&error=$em");
            exit;
        } else {

            $query = $conn->prepare("UPDATE t_classes_students SET class_id = ? WHERE id = ?");
            $query->execute([$class_id, $id]);

            $em = "Success !!";
            header("Location: ../../studentsList.php?id=$id&error=$em");
            exit;
        }
    } else {
        header("Location: ../../editStudentIndex.php");
        exit;
    }
} else {
    header("Location: ../../editStudentIndex.php");
    exit;
}
?>
