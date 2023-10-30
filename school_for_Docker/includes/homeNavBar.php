<?php 
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
 ?>
 	<link rel="stylesheet" href="../css/style.css">

	 <nav class="navbar navbar-expand-lg bg-light"
    	     id="homeNav">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="#">
		    	<img src="img/yavuzlar.png" width="40">
		    </a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" id="navbarSupportedContent">
		      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		        <li class="nav-item">
		          <a class="nav-link fw-semibold" aria-current="page" href="home.php">Home</a>
		        </li>
				<?php 
				if ($_SESSION['role'] === "admin") {
				?>			
		        <li class="nav-item">
		          <a class="nav-link fw-semibold" style="color: blueviolet;" href="usersList.php">Users List</a>
		        </li>
				<?php } 
				
				if ($_SESSION['role'] === "admin" || $_SESSION['role'] === "teacher") {
				?>
				<li class="nav-item">
		          <a class="nav-link fw-semibold" href="studentsList.php">Students List</a>
		        </li>
				<?php } 
				if ($_SESSION['role'] === "admin") {
				?>	
				<li class="nav-item">
		          <a class="nav-link fw-semibold" style="color: blueviolet;"  href="teachersList.php">Teachers List</a>
		        </li>
				<?php } ?>
				<li class="nav-item">
		          <a class="nav-link fw-semibold" href="classList.php">Class</a>
		        </li>
				<li class="nav-item">
		          <a class="nav-link fw-semibold" href="lessonsList.php">Lessons</a>
		        </li>
				<?php 
				if ($_SESSION['role'] === "admin" || $_SESSION['role'] === "teacher") {
				?>
				<li class="nav-item">
		          <a class="nav-link fw-semibold" href="examsList.php">Exams</a>
		        </li>
				<?php } ?>
		      </ul>
		      <ul class="navbar-nav me-right mb-2 mb-lg-0">
			  <li class="nav-item">
		          <a class="nav-link fw-bolder" href="profile.php">Profile</a>
		        </li>
		      	<li class="nav-item">
		          <a class="nav-link fw-bolder" href="app/logout.php">Logout</a>
		        </li>
		      </ul>
		  </div>
		    </div>
		</nav>

<?php }else {
	header("Location: login.php");
	exit;
} ?>