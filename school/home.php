<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Welcome to Yavuzlar School</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="icon" href="img/yavuzlar.png">
</head>
<body class="body-home">
    <div class="black-fill"><br /> <br />
    	<div class="container">

		<?php include("includes/homeNavBar.php"); ?>

        <section class="welcome-text d-flex justify-content-center align-items-center flex-column">
        	<img src="img/yavuzlar.png" >
        	<h4>Welcome to Yavuzlar School</h4>
        	<p>This project was carried out by Berkay Ataş to be delivered under the name of SIBER VATAN COMPETENCY CENTER project.</p>
        </section>
        <section id="about"
                 class="d-flex justify-content-center align-items-center flex-column">
        	<div class="card mb-3 card-1">
			  <div class="row g-0">
			    <div class="col-md-4">
			      <img src="img/yavuzlar.png" class="img-fluid rounded-start" >
			    </div>
			    <div class="col-md-8">
			      <div class="card-body">
			        <h5 class="card-title">About Project</h5>
			        <p class="card-text">  Siber Yavuzlar Web Application Security Team
											YAVUZLAR WEB SECURITY TEAM
											DUTY DIRECTIVE <br>
											Assignment Date: 28.09.2023<br>
											Task Delivery Date: 05.10.2023</p>
			        <p class="card-text"><small class="text-muted">Yavuzlar School</small></p>
			      </div>
			    </div>
			</div>
        </section>
       

    	</div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
</body>
</html>
<?php }else {
	header("Location: login.php");
	exit;
} ?>