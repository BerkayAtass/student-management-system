<?php
session_start();
include "../../conn.php";

if (isset($_SESSION['id']) && isset($_SESSION['role']) && $_SESSION['role'] === "admin") {
    if (isset($_POST['id'], $_POST['username'], $_POST['pass'], $_POST['role'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $username = $_POST['username'];
        $pass = $_POST['pass'];
        $role = $_POST['role'];

        $checkUsernameQuery = $conn->prepare("SELECT COUNT(*) as count FROM t_users WHERE username = ? AND id != ?");
        $checkUsernameQuery->execute([$username, $id]);
        $result = $checkUsernameQuery->fetch();

        if ($result['count'] > 0) {
        $em = "Username already exist!";
        header("Location: ../../editUserIndex.php?id=$id&error=$em");}
        

        $hashedPassword = password_hash($pass, PASSWORD_ARGON2ID);

        if (empty($name)) {
            $em = "Name is required";
            header("Location: ../../editUserIndex.php?id=$id&error=$em");
            exit;
        } elseif (empty($surname)) {
            $em = "Surname is required";
            header("Location: ../../editUserIndex.php?id=$id&error=$em");
            exit;
        } elseif (empty($username)) {
            $em = "Username is required";
            header("Location: ../../editUserIndex.php?id=$id&error=$em");
            exit;
        } elseif (empty($pass)) {
            $em = "Password is required";
            header("Location: ../../editUserIndex.php?id=$id&error=$em");
            exit;
        } elseif (empty($role)) {
            $em = "Role is required";
            header("Location: ../../editUserIndex.php?id=$id&error=$em");
            exit;
        } else {

            if ($role == 1) {
                $role  = "admin";
                
            } else if ($role == 2) {
                $role  = "student";
                
            } else if ($role == 3) {
                $role  = "teacher";
            }else{
                $em  = "Role is required";
                header("Location: ../../addUserIndex.php?error=$em");
            }

            $query = $conn->prepare("UPDATE t_users SET name = ?, surname = ?, username = ?, password = ?, role = ? WHERE id = ?");
            $query->execute([$name, $surname, $username, $hashedPassword, $role, $id]);

            $em = "Success !!";
            header("Location: ../../usersList.php?id=$id&error=$em");
            exit;
        }
    } else {
        header("Location: ../../editUserIndex.php");
        exit;
    }
} else {
    header("Location: ../../editUserIndex.php");
    exit;
}
?>
