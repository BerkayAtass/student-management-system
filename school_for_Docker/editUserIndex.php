<?php

include "conn.php";
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    $em = "Warning";
    header("Location: usersList.php?error=$em");
    exit;
} else{
    $id = $_GET['id'];
    $usersTable = "t_users";
    
    $query = $conn->prepare("SELECT * FROM $usersTable WHERE id = ?");
    $query->execute([$id]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    $name = $user['name'];
    $surname = $user['surname'];
    $username = $user['username'];
    $role = $user['role'];
}?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>User Edit</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="icon" href="img/yavuzlar.png">
</head>
<body class="body-login">
    <div class="black-fill"><br /> <br />
    	<div class="d-flex justify-content-center align-items-center flex-column">
    	<form class="login" action="app/user/editUser.php" method="POST">
    		<div class="text-center">
    			<img src="img/yavuzlar.png"
    			     width="100">
    		</div>
    		<h3>Edit User</h3>
			
			<?php if (isset($_GET['error'])) { ?>
    		<div class="alert alert-info" role="alert">
			  <?=$_GET['error']?>
			</div>
			<?php } ?>

       
            <div class="mb-3">
		    <label class="form-label">Name</label>
		    <input type="text" class="form-control" name="name" value="<?=$name?>" required>
		  </div>

          <div class="mb-3">
		    <label class="form-label">Surname</label>
		    <input type="text" class="form-control" name="surname" value="<?=$surname?>" required>
		  </div>
		  
          <div class="mb-3">
		    <label class="form-label">Username</label>
		    <input type="text" class="form-control" name="username" value="<?=$username?>" required>
		  </div>
		  
		  
		  <div class="mb-3">
		    <label class="form-label">Password</label>
		    <input type="password" class="form-control" name="pass" required>
		  </div>
		  
          <div class="mb-3">
		    <label class="form-label">Role</label>
		    <select class="form-control" name="role" required>
                <option value="1" <?php if($role == "admin") echo "selected"; ?>>Admin</option>
                <option value="2" <?php if($role == "student") echo "selected"; ?>>Student</option>
                <option value="3" <?php if($role == "teacher") echo "selected"; ?>>Teacher</option>
            </select>
		  </div>
        
          <!-- Hidden id sumbit  to app/user/editUser.php -->
          <input type="hidden" name="id" value="<?=$id?>">

		  <button type="submit" class="btn btn-primary">Edit</button>
		  <a href="home.php" class="btn btn-secondary" role="button" >Home</a>
		</form>
        
       
    	</div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
</body>
</html>