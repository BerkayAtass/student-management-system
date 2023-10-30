<?php
include "conn.php";

session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    $em = "Warning";
    header("Location: lessonsList.php?error=$em");
    exit;
} else{

$teacherRole = "teacher";
$query = $conn->prepare("SELECT id, name, surname FROM t_users WHERE role = ?");
$query->execute([$teacherRole]);

$teachers = $query->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Add Lesson</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="icon" href="img/yavuzlar.png">
</head>
<body class="body-login">
    <div class="black-fill"><br /> <br />
    	<div class="d-flex justify-content-center align-items-center flex-column">
    	<form class="login" action="app/lesson/addLesson.php" method="POST">
    		<div class="text-center">
    			<img src="img/yavuzlar.png"
    			     width="100">
    		</div>
    		<h3>ADD LESSON</h3>
			
			<?php if (isset($_GET['error'])) { ?>
    		<div class="alert alert-info" role="alert">
			  <?=$_GET['error']?>
			</div>
			<?php } ?>

       
		  
		  <div class="mb-3">
		    <label class="form-label">Lesson Name</label>
		    <input type="text" class="form-control" name="lesson_name" required>
		  </div>
		  
          <div class="mb-3">
		    <label class="form-label">Teacher Id</label>
		    <select class="form-control" name="teacher_id">
                <option value="0">Choose</option>
		    	<?php foreach ($teachers as $teacher) { ?>
                      <option value="<?= $teacher['id'] ?>"><?= $teacher['name'] . ' ' . $teacher['surname'] ?></option>
                 <?php } ?>
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