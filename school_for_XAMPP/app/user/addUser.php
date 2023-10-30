<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role']) && $_SESSION['role'] === "admin"){
    if (isset($_POST['username']) && isset($_POST['pass'])) {

        include "../../conn.php";
       
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $username = $_POST['username'];
        $pass = $_POST['pass'];
        $role = $_POST['role'];

        $hashedPassword = password_hash($pass, PASSWORD_ARGON2ID);
        if (empty($name)) {
            $em  = "Name is required";
            header("Location: ../../addUserIndex.php?error=$em");
            exit;
        } else if (empty($surname)) {
            $em  = "Surname is required";
            header("Location: ../../addUserIndex.php?error=$em");
            exit;
        } else if (empty($username)) {
            $em  = "Username is required";
            header("Location: ../../addUserIndex.php?error=$em");
            exit;
        }else if (empty($pass)) {
            $em  = "Password is required";
            header("Location: ../../addUserIndex.php?error=$em");
            exit;
        }else if (empty($role)) {
            $em  = "Role is required";
            header("Location: ../../addUserIndex.php?error=$em");
            exit;
        }else {
            $checkEmailQuery = $conn->prepare("SELECT COUNT(*) as count FROM t_users WHERE username = :username");
            $checkEmailQuery->bindParam(':username', $username);
            $checkEmailQuery->execute();
            $result = $checkEmailQuery->fetch();
    
            if ($result['count'] > 0) {  

                $em  = "Username already exist!";
                header("Location: ../../addUserIndex.php?error=$em");
                exit;

            }else{
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
            
                $school = "t_users";
                $query = $conn->prepare("INSERT INTO $school(name, surname, username, password, role) VALUES (?, ?, ?, ?, ?)");
                $query->execute(array(
                    $name,
                    $surname,
                    $username,
                    $hashedPassword,
                    $role,

                ));

                $em  = "Success";
                header("Location: ../../usersList.php?error=$em");
                exit;
            
            
             } 
        }
    } else {
        header("Location: ../../addUserIndex.php");
        exit;
    }
}else{
    header("Location: ../../addUserIndex.php");
        exit;
}
?>