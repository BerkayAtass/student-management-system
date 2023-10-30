<?php
include "conn.php";

session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['role']) || !($_SESSION['role'] === "admin" || $_SESSION['role'] === "teacher") ) {
    $em = "Warning";
    header("Location: examList.php?error=$em");
    exit;
} else{

    $usersTable = "t_users";
    $school = $conn->prepare("SELECT * FROM $usersTable ORDER BY id DESC");
    $school->execute();
    $users = $school->fetchAll(PDO::FETCH_ASSOC);

    $studentClass = "t_classes_students";
    $school = $conn->prepare("SELECT * FROM $studentClass ORDER BY id DESC");
    $school->execute();
    $studentClasses = $school->fetchAll(PDO::FETCH_ASSOC);

    $classes = "t_classes";
    $school = $conn->prepare("SELECT * FROM $classes ORDER BY id DESC");
    $school->execute();
    $classes = $school->fetchAll(PDO::FETCH_ASSOC);

    
    $lessonsTable = "t_lessons";
    $school = $conn->prepare("SELECT * FROM $lessonsTable ORDER BY id DESC");
    $school->execute();
    $lessons = $school->fetchAll(PDO::FETCH_ASSOC);

    $tempClassId = "";
    foreach ($classes as $class) {
        if($class["class_teacher_id"] === $_SESSION["id"]){
            $tempClassId = $class["id"];    
        } 
    }
    

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Add Exam</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="icon" href="img/yavuzlar.png">
</head>
<body class="body-login">
    <div class="black-fill"><br /> <br />
    	<div class="d-flex justify-content-center align-items-center flex-column">
    	<form class="login" action="app/exam/addExam.php" method="POST">
    		<div class="text-center">
    			<img src="img/yavuzlar.png"
    			     width="100">
    		</div>
    		<h3>ADD EXAM</h3>
			
			<?php if (isset($_GET['error'])) { ?>
    		<div class="alert alert-info" role="alert">
			  <?=$_GET['error']?>
			</div>
			<?php } ?>

                
            <div class="mb-3">
		    <label class="form-label">Student Id</label>
		    <select class="form-control" name="student_id">
                <option value="0">Choose</option>
		    	<?php 
                   
                   foreach ($studentClasses as $studentClass) {
                    if($_SESSION["role"] === "teacher" && !($tempClassId === $studentClass["class_id"])){
                        continue;
                    }
                        $name = "";
                        $surname = "";
                        foreach($users as $user) {
                            if($studentClass["student_id"] === $user["id"] ){
                                $name = $user["name"];
                                $surname = $user["surname"];
                            }
                        }
                    ?>
                        <option value="<?= $studentClass["student_id"] ?>"><?=  $name . ' ' . $surname  ?></option>
                    <?php 
                    
                        }
                ?>
		    </select>
		    </div>
		  
          <div class="mb-3">
		    <label class="form-label">Lesson Id</label>
		    <select class="form-control" name="lesson_id">
                <option value="0">Choose</option>
                <?php 
                foreach ($lessons as $lesson) {
                    if($_SESSION["role"] === "teacher" && !($lesson["teacher_user_id"] === $_SESSION["id"])){
                        continue;
                    }
                ?>
                <option value="<?php echo $lesson["id"]; ?>"><?php echo $lesson["lesson_name"]; ?></option>
                <?php } ?>
		    </select>
		  </div>

          
		  <div class="mb-3">
		    <label class="form-label">Exam Score</label>
		    <input type="text" class="form-control" name="exam_score" required>
		  </div>


		  <button type="submit" class="btn btn-primary">Add</button>
		  <a href="home.php" class="btn btn-secondary" role="button" >Home</a>
		</form>
        
       
    	</div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
</body>
</html>