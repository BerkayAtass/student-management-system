<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Add User</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="icon" href="img/yavuzlar.png">
</head>
<body class="body-login">
    <div class="black-fill"><br /> <br />
    	<div class="d-flex justify-content-center align-items-center flex-column">
    	<form class="login" action="app/user/addUser.php" method="POST">
    		<div class="text-center">
    			<img src="img/yavuzlar.png"
    			     width="100">
    		</div>
    		<h3>ADD USER</h3>
			
			<?php if (isset($_GET['error'])) { ?>
    		<div class="alert alert-info" role="alert">
			  <?=$_GET['error']?>
			</div>
			<?php } ?>

       
		  <div class="mb-3">
		    <label class="form-label">Name</label>
		    <input type="text" class="form-control" name="name" required>
		  </div>

          <div class="mb-3">
		    <label class="form-label">Surname</label>
		    <input type="text" class="form-control" name="surname" required>
		  </div>
		  
          <div class="mb-3">
		    <label class="form-label">Username</label>
		    <input type="text" class="form-control" name="username" required>
		  </div>
		  
		  
		  <div class="mb-3">
		    <label class="form-label">Password</label>
		    <input type="password" class="form-control" name="pass" required>
		  </div>
		  
          <div class="mb-3">
		    <label class="form-label">Role</label>
		    <select class="form-control" name="role">
                <option value="0">Choose</option>
		    	<option value="1">Admin</option>
		    	<option value="2">Student</option>
		    	<option value="3">Teacher</option>
		    </select>
		  </div>


		  <button type="submit" class="btn btn-primary">Add</button>
		  <a href="home.php" class="btn btn-secondary" role="button" >Home</a>
		</form>
        
       
    	</div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
</body>
</html>