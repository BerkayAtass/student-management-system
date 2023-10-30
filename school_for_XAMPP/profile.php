<?php 
session_start();
include "conn.php";
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {

	$usersTable = "t_users";
	$school = $conn->prepare("SELECT * FROM $usersTable ORDER BY id DESC");
	$school->execute();
	$users = $school->fetchAll(PDO::FETCH_ASSOC);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Profile</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="icon" href="img/yavuzlar.png">
</head>
<body class="body-login">
    <div class="black-fill"><br /> <br />
    	<div class="d-flex justify-content-center align-items-center flex-column">
    	<div class="login">
    		<div class="text-center">
    			<img src="img/yavuzlar.png"
    			     width="100">
    		</div>
    		<h3>Profile</h3>
			
			<?php if (isset($_GET['error'])) { ?>
    		<div class="alert alert-danger" role="alert">
			  <?=$_GET['error']?>
			</div>
			<?php } ?>

			<?php foreach ($users as $user) {
				if($_SESSION['id']  === $user['id']){
					echo '<div class="mb-3 ">
					<h5>ID: '.$user["id"].' <br></h5>
					<h5>Name: '.$user["name"].' <br></h5>
					<h5>Surname: '.$user["surname"].' <br></h5>
					<h5>Username: '.$user["username"].' <br></h5>
					<h5>Role: '.$user["role"].' <br></h5>
				  </div>';
				}
			} ?>

		  
		  <a href="changePassword.php" class="btn btn-primary" role="button" >Change Password</a>
		  <?php if($_SESSION["role"] == "student"){ ?>
		  
          <a href="studentInfo.php?id=<?php echo $_SESSION['id']; ?>" class="btn btn-block btn-info">Detailed Info</a>
       		<?php } ?>
		  <a href="home.php" class="btn btn-secondary" role="button" >Home</a>
		
        
       </div>
    	</div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
</body>
</html>
<?php }else {
	header("Location: login.php");
	exit;
} ?>