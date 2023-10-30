<?php
include "conn.php";

session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    $em = "Warning";
    header("Location: lessonsList.php?error=$em");
    exit;
} else{

    $id = $_GET['id'];
    

    $classes = "t_classes";
    $school = $conn->prepare("SELECT * FROM $classes ORDER BY id DESC");
    $school->execute();
    $classes = $school->fetchAll(PDO::FETCH_ASSOC);

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Student Edit</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="icon" href="img/yavuzlar.png">
</head>
<body class="body-login">
    <div class="black-fill"><br /> <br />
    	<div class="d-flex justify-content-center align-items-center flex-column">
    	<form class="login" action="app/student/editStudent.php" method="POST">
    		<div class="text-center">
    			<img src="img/yavuzlar.png"
    			     width="100">
    		</div>
    		<h3>EDIT STUDENT</h3>
			
			<?php if (isset($_GET['error'])) { ?>
    		<div class="alert alert-info" role="alert">
			  <?=$_GET['error']?>
			</div>
			<?php } ?>

       
		  
            <div class="mb-3">
		    <label class="form-label">Class Id</label>
		    <select class="form-control" name="class_id">
                <option value="0">Choose</option>
                <?php 
                foreach ($classes as $class) {
                    $classId = $class["id"];
                    $className = $class["class_name"];
                ?>
                <option value="<?php echo $classId; ?>"><?php echo "$classId - $className"; ?></option>
                <?php } ?>
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