<?php
session_start();

if (isset($_POST['username']) && isset($_POST['pass'])) {

    include "../conn.php";
    $username = $_POST['username'];
    $pass = $_POST['pass'];

    if (empty($username)) {
        $em  = "Username is required";
        header("Location: ../login.php?error=$em");
        exit;
    } else if (empty($pass)) {
        $em  = "Password is required";
        header("Location: ../login.php?error=$em");
        exit;
    } else {
        $sql = "SELECT id, username, password, role FROM t_users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username]);

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch();
            $storedUsername = $user['username'];
            $storedPassword = $user['password'];
            $role = $user['role'];
            $id = $user['id'];
            if ($storedUsername === $username) {
                if (password_verify($pass, $storedPassword)) {
                    $_SESSION['id'] = $id;
                    $_SESSION['username'] = $storedUsername;
                    $_SESSION['role'] = $role;
                    //$_SESSION['name'] = $storedName;
                    //$_SESSION['surname'] = $storedSurname;
                    header("Location: ../home.php");
                } else {
                    $em  = "Incorrect Username or Password";
                    header("Location: ../login.php?error=$em");
                }
            } else {
                $em  = "Incorrect Username or Password";
                header("Location: ../login.php?error=$em");
            }
        } else {
            $em  = "Incorrect Username or Password";
            header("Location: ../login.php?error=$em");
        }
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
