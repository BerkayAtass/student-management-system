<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role']) && $_SESSION['role'] === "admin"){
    if (isset($_POST['oldPass']) && isset($_POST['newPass']) && isset($_POST['newPassTemp'])) {

        include "../conn.php";
       
        $id = $_SESSION['id'];
        $oldPass = $_POST['oldPass'];
        $newPass = $_POST['newPass'];
        $newPassTemp = $_POST['newPassTemp'];

        if (empty($oldPass)) {
            $em  = "Old password is required";
            header("Location: ../changePassword.php?error=$em");
            exit;
        } else if (empty($newPass)) {
            $em  = "New password is required";
            header("Location: ../changePassword.php?error=$em");
            exit;
        } else if (empty($newPassTemp)) {
            $em  = "Confirm new password is required";
            header("Location: ../changePassword.php?error=$em");
            exit;
        } else if (!($newPass === $newPassTemp)) {
            $em  = "New password and confirm password must be same!";
            header("Location: ../changePassword.php?error=$em");
            exit;
        } else {
            $usersTable = "t_users";
            $school = $conn->prepare("SELECT * FROM $usersTable WHERE id = ?");
            $school->execute([$id]);
            $user = $school->fetch(PDO::FETCH_ASSOC);

            if ($_SESSION['id'] === $user['id']) {
                if (!password_verify($oldPass, $user['password'])) {
                    $em  = "Old password is incorrect";
                    header("Location: ../changePassword.php?error=$em");
                    exit;
                } else {
                    $newPass = password_hash($newPass, PASSWORD_ARGON2ID);
                    $query = $conn->prepare("UPDATE t_users SET password = ? WHERE id = ?");
                    $query->execute([$newPass, $id]);
                    $em  = "Password changed successfully";
                    header("Location: ../profile.php?error=$em");
                    exit;
                }
            } else {
                $em  = "User not found";
                header("Location: ../changePassword.php?error=$em");
                exit;
            }
        }
    } else {
        header("Location: ../changePassword.php");
        exit;
    }
} else {
    header("Location: ../changePassword.php");
    exit;
}
?>
