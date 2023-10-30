<?php 
session_start();
include "conn.php";
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Change Password</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="icon" href="img/yavuzlar.png">
</head>
<body class="body-login">
    <div class="black-fill"><br /> <br />
    	<div class="d-flex justify-content-center align-items-center flex-column">
    	<form class="login" action="app/changePassFunction.php" method="POST">
    		<div class="text-center">
    			<img src="img/yavuzlar.png"
    			     width="100">
    		</div>
    		<h3>Change Password</h3>
			
			<?php if (isset($_GET['error'])) { ?>
    		<div class="alert alert-danger" role="alert">
			  <?=$_GET['error']?>
			</div>
			<?php } ?>


		  <div class="mb-3">
		    <label class="form-label">Old Password</label>
		    <input type="password" class="form-control" name="oldPass">
		  </div>
		  
		  <div class="mb-3">
		    <label class="form-label">New Password</label>
		    <input type="password" class="form-control" name="newPass">
		  </div>
          
          <div class="mb-3">
		    <label class="form-label">Confirm New Password</label>
		    <input type="password" class="form-control" name="newPassTemp">
		  </div>



		  <button type="submit" class="btn btn-primary">Change</button>
		  <a href="profile.php" class="btn btn-secondary" role="button" >Profile</a>
		</form>
        
       
    	</div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
</body>
</html>
<?php }else {
	header("Location: login.php");
	exit;
} ?>